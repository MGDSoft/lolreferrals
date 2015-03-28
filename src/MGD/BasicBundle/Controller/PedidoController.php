<?php

namespace MGD\BasicBundle\Controller;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\Articulo;
use MGD\BasicBundle\Entity\CuponDescuento;
use MGD\BasicBundle\Event\PedidoPagadoEvent;
use MGD\BasicBundle\Form\CuponDescuentoType;
use MGD\BasicBundle\Form\PedidoType;

use MGD\BasicBundle\Service\PedidoPagoService;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Routing\Router;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


class PedidoController extends Controller
{

    /**
     * @var Request
     *
     * @DI\Inject
     */
    protected $request;

    /**
     * @var Session
     *
     * @DI\Inject
     */
    protected $session;

    /**
     * @var EntityManager
     *
     * @DI\Inject("doctrine.orm.entity_manager")
     */
    protected $em;

    /**
     * @var Logger $log
     *
     * @DI\Inject("logger")
     */
    protected $log;

    /**
     * @var Router
     *
     * @DI\Inject
     */
    protected $router;

    /**
     * @var PedidoPagoService
     *
     * @DI\Inject("pedido.pago_service")
     */
    protected $pedidoPago;

    /**
     * @var CuponDescuentoController
     *
     * @DI\Inject("cupon_descuento.controller")
     */
    protected $cDescController;


    /**
     * @Route("/en/order/",defaults={"_locale" = "en"}, name="pedido_en")
     * @Route("/es/comprar/",defaults={"_locale" = "es"}, name="pedido_es")
     * @Route("/de/bestellen/",defaults={"_locale" = "de"}, name="pedido_de")
     * @Route("/order/post/", name="pedido_post")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $cuponDescuentoForm = $this->cDescController->indexForm();
        $nReferidosStart = 5;
        /** @var \MGD\BasicBundle\Entity\PrecioRango[] $precioRangos */
        $precioRangos = $this->em->getRepository("MGDBasicBundle:PrecioRango")->findBy(
            array(),
            array('limite' => 'ASC')
        );

        $descuento = $this->getDescuentoSession();

        $pedido = new Pedido();
        $pedido->setNReferidos($nReferidosStart);

        $form = $this->createForm(new PedidoType(), $pedido);

        if ($request->getMethod() === 'POST' && $request->request->get('mgd_basicbundle_pedidotype')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                return $this->pedidoPostAction($pedido);
            }
        }

        $eurosToDollars = 1.39;

        return array(
            'eurosToDollars'     => $eurosToDollars,
            'nReferidosStart'    => $nReferidosStart,
            'pedidoForm'         => $form->createView(),
            'descuento'          => $descuento,
            'precioRangos'       => $precioRangos,
            'cuponDescuentoForm' => $cuponDescuentoForm->createView(),
        );
    }


    /**
     * @return CuponDescuento
     */
    private function getDescuentoSession()
    {
        if (!$cuponDescuento = $this->getRequest()->getSession()->get('cuponDescuento')) {
            return null;
        }

        $serializer = $this->container->get('jms_serializer');

        if (!$cuponDescuento = $serializer->deserialize(
            $cuponDescuento,
            'MGD\BasicBundle\Entity\CuponDescuento',
            'json'
            )
        ) {
            return null;
        }

        /** @var CuponDescuento $cuponDescuentoEntity */
        $cuponDescuentoEntity = $this->em->merge($cuponDescuento);
        $this->em->refresh($cuponDescuentoEntity);
        if (!$cuponDescuentoEntity) {
            return null;
        }

        if (!$cuponDescuentoEntity->validarCupon()) {
            $this->session->remove('cuponDescuento');

            return null;
        }

        return $cuponDescuentoEntity;
    }


    public function pedidoPostAction(Pedido $pedido)
    {
        if (($cuponDescuento = $this->getDescuentoSession()) && $cuponDescuento->validarCupon()) {
            $pedido->setCuponDescuento($cuponDescuento);
        }

        if (!$precioRango = $this->em->getRepository("MGDBasicBundle:PrecioRango")->getRowByNReferidos($pedido->getNReferidos())){
            $this->log->addCritical("No hay rango para " . $pedido->getNReferidos());
        }

        $pedido->setPrecioRango($precioRango);
        $pedido->calculatePrice();
        $instruction = $this->pedidoPago->generateInstructions($pedido);

        // Update the order object
        $pedido->setPaymentInstruction($instruction);
        $this->em->persist($pedido);
        $this->em->flush();

        return $this->completeAction($pedido);
    }

    /**
     * @Route("/{pedido_id}/complete", name = "payment_complete_mgd")
     * @ParamConverter("pedido", class="MGDBasicBundle:Pedido", options={"id" = "pedido_id"})
     */
    public function completeAction(Pedido $pedido)
    {
        if (($url = $this->pedidoPago->verifyPaymentCompleted($pedido)) !== true) {
            return new RedirectResponse($url);
        }

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('mgd.pedido_pagado', new PedidoPagadoEvent($pedido));

        return new RedirectResponse($this->router->generate('home',
            array(
                '_locale' => $pedido->getLanguage(),
                'completed' => time(), // Needed to remove cache and show flashbags messages
            ))
        );
    }

    /**
     * @Route("/{pedido_id}/cancel", name = "payment_cancel_mgd")
     */
    public function cancelAction()
    {
        return new RedirectResponse($this->router->generate('home'));
    }

}
