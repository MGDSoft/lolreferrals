<?php
/**
 * Created by MGDSoftware. 4/03/14
 */

namespace MGD\BasicBundle\Listener\Entity;


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
use Symfony\Component\DependencyInjection\ContainerInterface;

class PedidoEntityListener extends EntityListenerAssistEvents implements EventSubscriber
{
    /**
     * @var Pedido
     */
    protected  $entity;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var Pedido[]
     */
    private $pedidoInserted=array();

    /**
     * @var Pedido[]
     */
    private $pedidoUpdated=array();


    function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
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
                $this->logger->addCritical('No hay estado en cola!');
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

        $this->em->persist($pedidoEstados);
    }

    protected function createAccPPPayment(Pedido $pedido)
    {
        if (!$ppAccountActive = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->findOneByActive(true))
        {
            $this->logger->addCritical('No hay cuenta activa!');
            return true;
        }

        $ppAccountPayment = new PaypalAccountsPayment();

        $ppAccountPayment
            ->setPaypalAccount($ppAccountActive)
            ->setPedido($pedido)
        ;

        if ($pedido->getPaymentInstruction())
        {
            $ppAccountPayment->setPrecioPaypalNeto($pedido->getTotal());
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
            return true;
        }

        if ($accPay->getPrecio() == $pedido->getTotal())
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