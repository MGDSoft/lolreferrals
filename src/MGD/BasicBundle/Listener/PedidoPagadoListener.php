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

class PedidoPagadoListener
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

        $this->session->getFlashBag()->add('success',
            $this->translator->trans('pago.finalizado')
        );

        $estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
        $pedido->setEstado($estado);

        if ($cupon = $pedido->getCuponDescuento())
        {
            $cupon->sumaUso();
        }

        $pedidoEstados = new PedidoEstados();
        $pedidoEstados->setEstado($estado);
        $pedidoEstados->setPedido($pedido);

        $this->em->persist($pedidoEstados);

        $this->em->flush();
        $this->enviarCorreo($pedido);
        $this->enviarCorreoAdmin($pedido);

        $this->session->remove('cuponDescuento');

    }

    private function enviarCorreo(Pedido $pedido)
    {
        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('pago.correo.asunto'))
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($pedido->getEmail(), $pedido . " ". $pedido->getRefPaypal())
            ->setBody($this->templating->render('MGDBasicBundle:Pedido:confirmation_email.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                    )
                ), 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
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
            ->setBody($this->templating->render('MGDBasicBundle:Pedido:confirmation_email_admin.html.twig',
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                        'referralsLink' => $referralsLink,
                        'email' => $email,
                    )
                ), 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail().", despues del pago");
        }
    }

}