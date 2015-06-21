<?php
/**
 * This listener doesnt mandatory, but doctrine extension Transtable set language with locale
 * Created by mongo_example.
 * User: PC
 * Date: 22/11/13
 * Time: 23:49
 */

namespace MGD\BasicBundle\Listener;

use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\CuentaUsuario;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\BasicBundle\Event\PedidoPagadoEvent;
use Monolog\Logger;
use Swift_Mailer;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JMS\Payment\CoreBundle\PluginController\Event\PaymentStateChangeEvent;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Translator;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;

class FinalizarPagoListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TimedTwigEngine
     */
    private $templating;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Logger
     */
    private $log;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->session = $container->get('session');
        $this->translator = $container->get('translator');
        $this->templating = $container->get('templating');
        $this->mailer = $container->get('mailer');
        $this->log = $container->get('logger');
    }

    public function onPayment(PedidoPagadoEvent $pedidoEvent)
    {

        $pedido = $pedidoEvent->getPedido();


        $estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
        $pedido->setEstado($estado);

        if ($cupon = $pedido->getCuponDescuento())
        {
            $cupon->sumaUso();
        }

        $this->em->flush();

        $cuentaUsuario = null;

        if ($cuenta = $pedido->getCuenta())
        {
            $estadoFinalizado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Finalizado);
            $pedido->setEstado($estadoFinalizado);

            if (!$cuentaUsuario = $cuenta->getPrimeraCuentaUsuarioNoUsada())
            {
                $this->enviarCorreoAdminProblemaConcurrecia($pedido);

                return;
            }

            $cuentaUsuario->setUsado(true);
            $this->session->getFlashBag()->add('success',
                $this->translator->trans('pago.finalizado_cuenta', array(), null, $pedido->getLanguage())
            );

        }else{
            $this->session->getFlashBag()->add('success',
                $this->translator->trans('pago.finalizado', array(), null, $pedido->getLanguage())
            );
        }
        $this->em->flush();

        $this->enviarCorreo($pedido, $cuentaUsuario);
        $this->enviarCorreoAdmin($pedido, $cuentaUsuario);

        $this->session->remove('cuponDescuento');

    }

    private function enviarCorreo(Pedido $pedido, CuentaUsuario $cuentaUsuario=null)
    {
        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('correo.pago.asunto', array(), null, $pedido->getLanguage()))
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($pedido->getEmail())
            ->setBody($this->templating->render('MGDBasicBundle:Mails/OrderEnd:confirmation_email.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                        'lang' => $pedido->getLanguage(),
                        'cuentaUsuario' => $cuentaUsuario
                    )
                ), 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

    private function enviarCorreoAdmin(Pedido $pedido, CuentaUsuario $cuentaUsuario=null)
    {
        $referralsLink = $pedido->getReferralLink();
        $email = $pedido->getEmail();

        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject('Nuevo pedido '.$pedido)
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($this->container->getParameter('email_pedido'), $pedido . " ". $pedido->getRefPaypal())
            ->setBody($this->templating->render('MGDBasicBundle:Mails/OrderEnd:confirmation_email_admin.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                        'referralsLink' => $referralsLink,
                        'email' => $email,
                        'cuentaUsuario' => $cuentaUsuario
                    )
                ), 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

    private function enviarCorreoAdminProblemaConcurrecia(Pedido $pedido)
    {
        $referralsLink = $pedido->getReferralLink();
        $email = $pedido->getEmail();

        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject('Pedido Sin stock (Concurrencia) '.$pedido)
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($this->container->getParameter('email_pedido'), $pedido . " ". $pedido->getRefPaypal())
            ->setBody(
                "usuario email: $email, cuenta= ".$pedido->getCuenta()->getId()
            , 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

}