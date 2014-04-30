<?php
/**
 * Created by MGDSoftware. 4/03/14
 */

namespace MGD\BasicBundle\Listener\Entity;


use Container;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\PaypalAccountsPayment;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use Doctrine\ORM\Event\OnFlushEventArgs;
use MGD\FrameworkBundle\Listener\Entity\EntityListenerAssistEvents;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PedidoEntityListener extends EntityListenerAssistEvents implements EventSubscriber
{
    /**
     * @var Pedido
     */
    protected  $entity;

    /**
     * @var Logger
     */
    private $log;

    /**
     * @var Pedido[]
     */
    private $pedidoInserted=array();

    /**
     * @var Pedido[]
     */
    private $pedidoUpdated=array();

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Swift_Mailer
     */
    private $mailer;


    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->log = $container->get('logger');
        $this->translator = $container->get('translator');
        $this->mailer = $container->get('mailer');
    }

    public function onFlush(OnFlushEventArgs  $eventArgs)
    {
        $this->setUpFlush($eventArgs);

        foreach ($this->uow->getScheduledEntityInsertions() as $entity)
        {
            if ($entity instanceof Pedido)
            {
                $this->pedidoInserted []= $entity;
            }
        }

        foreach ($this->uow->getScheduledEntityUpdates() AS $entity)
        {
            if ($entity instanceof Pedido)
            {
                $this->pedidoUpdated []= $entity;
            }
        }
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $this->em = $args->getEntityManager();

        foreach ($this->pedidoInserted as $entity)
        {
            $this->setLanguage($entity);
            $this->createHistoryStates($entity);
            $this->createAccPPPayment($entity);
        }

        foreach ($this->pedidoUpdated AS $entity)
        {
            $this->createHistoryStates($entity);
            $this->modifyValueFromPaypalAccount($entity);
        }

        if ($this->pedidoUpdated || $this->pedidoInserted )
        {
            $this->pedidoUpdated=$this->pedidoInserted=array();
            $this->em->flush();
        }

    }

    protected function setLanguage(Pedido $pedido)
    {
        /** @var SessionInterface $session */
        $session = $this->container->get('session');

        if (!$locale = $session->get('_locale'))
        {
            $locale = $this->container->getParameter('locale');
        }

        $pedido->setLanguage($locale);
    }

    protected function createHistoryStates(Pedido $pedido)
    {
        if (!$pedido->getEstado())
        {
            if ($pedido->getPaymentInstruction())
            {
                return true;
            }

            if(!$estado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola))
            {
                $this->log->addCritical('No hay estado en cola!');
                return true;
            }

            $pedido->setEstado($estado);
            $this->em->persist($pedido);

        }else{

            $oldEntityEstate = $this->em->getRepository('MGDBasicBundle:PedidoEstados')->findOneBy(array('pedido' => $pedido),array('fecha'=>'DESC'));

            if ($oldEntityEstate && $oldEntityEstate->getEstado()->getId() == $pedido->getEstado()->getId())
            {
                return true;
            }
        }

        $pedidoEstados  = new PedidoEstados();
        $pedidoEstados->setEstado($pedido->getEstado());
        $pedidoEstados->setPedido($pedido);

        // Pending....
        //$pedidoEstados->setDescripcion($pedido->getEstado()->getDescripcionAdmin());

        $this->em->persist($pedidoEstados);

        if ($pedido->getEstado()->getId() == EstadoEnum::Procesando || $pedido->getEstado()->getId() == EstadoEnum::Finalizado)
        {
            $this->sendEmailSwitchingEstado($pedido);
        }
    }

    private function sendEmailSwitchingEstado(Pedido $pedido)
    {
        $template = $this->container->get('templating');
        $estadoId=$pedido->getEstado()->getId();

        $message = \Swift_Message::newInstance()->setSubject(
                $this->translator->trans(
                    "correo.estado_change_$estadoId.asunto",
                    array('%nReferidos%' => $pedido->getNReferidos()),
                    null,
                    $pedido->getLanguage()
                )
            )
            ->setFrom($this->container->getParameter('email_app'), $this->translator->trans("correo.from_txt", array(), null, $pedido->getLanguage()))
            ->setTo($pedido->getEmail())
            ->setBody($template->render("MGDBasicBundle:Mails/PedidoEstado:changing_state_$estadoId.html.twig",
                    // Prepare the variables to populate the email template:
                    array(
                        'pedido' => $pedido,
                        'lang' => $pedido->getLanguage(),
                    )
                ), 'text/html'
            )
        ;

        if (!$this->mailer->send($message))
        {
            $this->log->addCritical("No se ha enviado el correo para ".$pedido->getEmail()." despues del cambio de estado del pedido ". $pedido->getId());
        }
    }

    protected function createAccPPPayment(Pedido $pedido)
    {
        if (!$pedido->getEstado())
        {
            // temp order
            return true;
        }

        if (!$ppAccountActive = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->findOneByActive(true))
        {
            $this->log->addCritical('No hay cuenta activa!');
            return true;
        }

        $ppAccountPayment = new PaypalAccountsPayment();

        $ppAccountPayment
            ->setPaypalAccount($ppAccountActive)
            ->setPedido($pedido)
        ;

        if ($pedido->getPaymentInstruction())
        {
            $ppAccountPayment->setPrecio($pedido->getPrecioPaypalNeto());
        }else{
            $ppAccountPayment->setPrecio($pedido->getTotal());
        }

        $this->em->persist($ppAccountPayment);
    }

    protected function modifyValueFromPaypalAccount(Pedido $pedido)
    {
        if (!$pedido->getId())
            return null;

        /** @var PaypalAccountsPayment $accPay */
        if (!$accPay = $this->em->getRepository('MGDBasicBundle:PaypalAccountsPayment')->findOneByPedido($pedido))
        {
            $dateUpdateArticulos=new \DateTime('2014-03-16 00:00:00');
            if ($pedido->getFecha()->getTimestamp() > $dateUpdateArticulos->getTimestamp() )
            {
                $this->createAccPPPayment($pedido);
            }

            return true;
        }

        if ($accPay->getPrecio() == $pedido->getTotal() || $accPay->getPrecio() == $pedido->getPrecioPaypalNeto())
        {
            return true;
        }

        $acc = $accPay->getPaypalAccount();

        $acc->setDineroAgregadoTotal($pedido->getTotal() - $accPay->getPrecio() + $acc->getDineroAgregadoTotal());
        $acc->setDineroAgregado($pedido->getTotal() - $accPay->getPrecio() + $acc->getDineroAgregado());

        $accPay->setPrecio($pedido->getTotal());

        $this->em->persist($accPay);
        $this->em->persist($acc);
    }


    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'onFlush',
            'postFlush'
        );
    }
}