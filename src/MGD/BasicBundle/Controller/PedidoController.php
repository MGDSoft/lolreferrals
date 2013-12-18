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
    protected  $request;

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
    * @Template()
    */
    public function indexAction()
    {
        $cuponDescuentoForm = $this->cDescController->indexForm();

	    /** @var \MGD\BasicBundle\Entity\Articulo[] $articulos */
	    $articulos = $this->em->getRepository("MGDBasicBundle:Articulo")->findAll();

        $descuento = $this->getDescuentoSession();
	    foreach($articulos as $articulo)
	    {
            if ($descuento)
                $articulo->setDescuento($descuento);

            $form = $this->createForm(new PedidoType($articulo->getId()), null);
            $articulo->setForm($form->createView());
	    }


	    return array(
            'descuento' => $descuento,
		    'articulos' => $articulos,
            'cuponDescuentoForm' => $cuponDescuentoForm->createView(),
	    );
    }

    /**
     * @return CuponDescuento
     */
    private function getDescuentoSession()
    {
        if (! $cuponDescuento = $this->getRequest()->getSession()->get('cuponDescuento'))
            return null;

        $serializer = $this->container->get('jms_serializer');

        if (!$cuponDescuento = $serializer->deserialize($cuponDescuento,'MGD\BasicBundle\Entity\CuponDescuento', 'json'))
            return null;


        /** @var CuponDescuento $cuponDescuentoEntity */
        $cuponDescuentoEntity = $this->em->merge($cuponDescuento);
        $this->em->refresh($cuponDescuentoEntity);
        if(!$cuponDescuentoEntity)
            return null;

        if (!$cuponDescuentoEntity->validarCupon())
        {
            $this->session->remove('cuponDescuento');

            return null;
        }

        return $cuponDescuentoEntity;
    }


    /**
     * @Route("/order/{articulo_id}/post", name="pedido_post")
     * @ParamConverter("articulo", class="MGDBasicBundle:Articulo", options={"id" = "articulo_id"})
     * @Method({"POST"})
     */
    public function pedidoPostAction(Articulo $articulo)
    {
        $pedido = new Pedido();

        $form = $this->createForm(new PedidoType($articulo->getId()), $pedido);
        $form->handleRequest($this->request);

        if (!$form->isValid())
            return $this->redirect($this->router->generate('pedido_'.$this->session->get('_locale')));


        if (($cuponDescuento = $this->getDescuentoSession()) && $cuponDescuento->validarCupon())
        {
            $articulo->setDescuento($cuponDescuento);
            $pedido->setCuponDescuento($cuponDescuento);
        }

        $pedido->setArticulo($articulo);
        $pedido->setEstado(null);
        $pedido->setTotal($articulo->getPrecioReal());

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
        if (($url = $this->pedidoPago->verifyPaymentCompleted($pedido))!== true)
            return new RedirectResponse($url);


        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('mgd.pedido_pagado',new PedidoPagadoEvent($pedido));

        return new RedirectResponse($this->router->generate('home'));
    }

    /**
     * @Route("/{pedido_id}/cancel", name = "payment_cancel_mgd")
     */
    public function cancelAction()
    {
        return new RedirectResponse($this->router->generate('home'));
    }

}
