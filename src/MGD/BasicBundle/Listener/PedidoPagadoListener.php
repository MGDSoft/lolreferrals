<?php
/**
 * This listener doesnt mandatory, but doctrine extension Transtable set language with locale
 * Created by mongo_example.
 * User: PC
 * Date: 22/11/13
 * Time: 23:49
 */

namespace MGD\BasicBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JMS\Payment\CoreBundle\PluginController\Event\PaymentStateChangeEvent;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use Doctrine\ORM\EntityManager;

class PedidoPagadoListener
{
    /**
     * @var object
     */
    private $redis;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onPaymentStateChange(PaymentStateChangeEvent $event)
    {
        $state=$event->getNewState();
        switch ($event->getNewState()) {
            case PaymentInterface::STATE_APPROVED:
            {
                /** @var Pedido $pedido */
                $pedido = $this->em->getRepository('MGDBasicBundle:Pedido')->findOneByPaymentInstruction(
                    $event->getPaymentInstruction()
                );

                $estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);
                $pedido->setEstado($estado);

                $this->em->flush();
                $this->enviarCorreo($pedido);
                $this->enviarCorreoAdmin($pedido);
                break;
            }
        }
    }

    private function enviarCorreo(Pedido $pedido)
    {
        //preparing message
        $message = \Swift_Message::newInstance()
            ->setSubject($this->get('translator')->trans('pago.correo.asunto'))
            ->setFrom($this->container->getParameter('email_app'), 'ReferralLol.com')
            ->setTo($pedido->getEmail(), $pedido . " ". $pedido->getRefPaypal())
            ->setBody($this->renderView('MGDBasicBundle:Pedido:confirmation_email.html.twig',
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
            ->setBody($this->renderView('MGDBasicBundle:Pedido:confirmation_email_admin.html.twig',
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

}