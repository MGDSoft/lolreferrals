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
use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\PaypalAccountsPayment;
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

class PaypalPalccountListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Logger
     */
    private $log;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->log = $container->get('logger');
    }

    public function onPayment(PedidoPagadoEvent $pedidoEvent)
    {

        $pedido = $pedidoEvent->getPedido();

        $ppAccount = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->getOneByActive();

        $ppAccountPayment = new PaypalAccountsPayment();

        $ppAccountPayment
            ->setPedido($pedido)
            ->setPrecioPaypalNeto($pedido->getTotal())
            ->setPaypalAccount($ppAccount)
        ;

        $this->em->persist($ppAccountPayment);

        $this->em->flush();

        $this->log->addInfo("On payment, agregado ".$ppAccountPayment->getPrecio()." EUR a ".$ppAccount->getName());
    }

}