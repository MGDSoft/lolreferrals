<?php

namespace MGD\BasicBundle\Controller;

use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\Articulo;
use MGD\BasicBundle\Form\PedidoType;

use MGD\BasicBundle\PedidoPago;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation as DI;

class PedidoController extends Controller
{

    /**
     * @var Request
     *
     * @DI\Inject
     */
    protected  $request;

    /**
     * @var AbstractManagerRegistry
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
     * @var PedidoPago
     *
     * @DI\Inject("pedido.pago")
     */
    protected $pedidoPago;

	/**
     * @Route("/en/order/",defaults={"_locale" = "en"}, name="pedido_en")
     * @Route("/es/comprar/",defaults={"_locale" = "es"}, name="pedido_es")
	 * @Route("/de/bestellen/",defaults={"_locale" = "de"}, name="pedido_de")
     * @Template()
     */
    public function indexAction()
    {
	    /** @var \MGD\BasicBundle\Entity\Articulo[] $articulos */
	    $articulos = $this->em->getRepository("MGDBasicBundle:Articulo")->findAll();

	    foreach($articulos as $articulo)
	    {
            $form = $this->createForm(new PedidoType(), null);
            $articulo->setForm($form->createView());
	    }

	    return array(
		    'articulos' => $articulos,
	    );

    }

    /**
     * @Route("/order/{articulo_id}/post", name="pedido_post")
     * @ParamConverter("articulo", class="MGDBasicBundle:Articulo", options={"id" = "articulo_id"})
     * @Method({"POST"})
     */
    public function pedidoPostAction(Articulo $articulo)
    {
        $pedido = new Pedido();

        $form = $this->createForm(new PedidoType(), $pedido);
        $form->handleRequest($this->request);

        if (!$form->isValid()) {
            return $this->redirect($this->router->generate('pedido_'.$this->session->get('_locale')));
        }

        $pedido->setArticulo($articulo);
        $estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
        $pedido->setEstado($estado);
        // Aplicando descuento?¿

        $pedido->setTotal($articulo->getPrecio());

        $instruction = $this->pedidoPago->generateInstructions($pedido);

        // Update the order object
        $pedido->setPaymentInstruction($instruction);
        $this->em->persist($pedido);
        $this->em->flush();

//        $this->completeAction($pedido);

        // Continue with payment
        return new RedirectResponse($this->router->generate('payment_complete_mgd', array(
                'pedido_id' => $pedido->getId(),
            )));
    }

    /**
     * @Route("/{pedido_id}/complete", name = "payment_complete_mgd")
     * @ParamConverter("pedido", class="MGDBasicBundle:Pedido", options={"id" = "pedido_id"})
     */
    public function completeAction(Pedido $pedido)
    {
        if (($url = $this->pedidoPago->verifyPaymentCompleted($pedido))!== true)
        {
            return new RedirectResponse($url);
        }

        $this->pagado($pedido);
    }

    private function pagado(Pedido $pedido)
    {
        $this->log->info('Validado pago');

        //$refenciaPaypal = $this->paypal_ipn->getOrder()->getTxnId();

        $estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
        $pedido->setEstado($estado);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->log->info('pedido insertado CORRECTAMENTE!');

        $this->enviarCorreo($pedido);
        $this->enviarCorreoAdmin($pedido); //copia

    }

    private function enviarCorreo(Pedido $pedido)
    {
        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject($this->get('translator')->trans('pago.correo.asunto'))
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($pedido->getEmail(), $pedido . " ". $pedido->getRefPaypal())
            ->setBody($this->renderView('OrderlyPayPalIpnBundle:Default:confirmation_email.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                    )
                ), 'text/html')
        ;

        if (!$this->get('mailer')->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

    private function enviarCorreoAdmin(Pedido $pedido)
    {
        $referralsLink = $pedido->getReferralLink();
        $email = $pedido->getEmail();

        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject('Nuevo pedido '.$pedido)
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($this->container->getParameter('email_pedido'), $pedido . " ". $pedido->getRefPaypal())
            ->setBody($this->renderView('OrderlyPayPalIpnBundle:Default:confirmation_email_admin.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                        'referralsLink' => $referralsLink,
                        'email' => $email,
                    )
                ), 'text/html')
        ;

        if (!$this->get('mailer')->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

    /**
     * @Route("/{pedido_id}/cancel", name = "payment_cancel_mgd")
     */
    public function cancelAction()
    {

    }

}
