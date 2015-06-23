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


class CuentaController extends Controller
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
     * @Route("/en/account/", defaults={"_locale" = "en"}, name="cuenta_en")
     * @Route("/es/cuentas/",defaults={"_locale" = "es"}, name="cuenta_es")
     * @Route("/de/konto/",defaults={"_locale" = "de"}, name="cuenta_de")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $cuponDescuentoForm = $this->cDescController->indexForm();
        $descuento = $this->getDescuentoSession();
        /** @var \MGD\BasicBundle\Entity\Cuenta[] $cuentas */
        $cuentas = $this->em->getRepository("MGDBasicBundle:Cuenta")->findBy(array(), array('precio'=> 'ASC'));

        return array(
            'cuentas'     => $cuentas,
            'descuento'   => $descuento,
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
}
