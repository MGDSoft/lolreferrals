<?php
/**
 * Created by MGDSoftware. 4/03/14
 */

namespace MGD\BasicBundle\Listener\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\PaypalAccountsPayment;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

class PaypalAccountsPaymentEntityListener
{
    /**
     * @var PaypalAccountsPayment
     */
    protected  $entity;

    /**
     * @var EntityManager
     */
    private $em;

    public  function prePersist(LifecycleEventArgs $args)
    {
        if (!$this->setUp($args))
            return false;

        $this->sumMoneyToPaypalAccount();
        $this->rotateIfExceedLimitPaypalAccount();
    }

    private function setUp(LifecycleEventArgs $args)
    {
        $this->entity = $args->getEntity();
        $this->em = $args->getEntityManager();

        if (!$this->entity instanceof PaypalAccountsPayment)
            return false;

        return true;
    }

    protected function sumMoneyToPaypalAccount()
    {
        if(!$ppAccount=$this->entity->getPaypalAccount())
            return true;

        $ppAccount->sumDineroAgregado($this->entity->getPrecio());
    }

    protected function rotateIfExceedLimitPaypalAccount()
    {
        if(!$ppAccount=$this->entity->getPaypalAccount())
            return false;

        if ($ppAccount->getDineroAgregado() < $ppAccount->getDineroParaRotar())
            return false;

        // $ppAccount->setActive(false); Executed internally by an event
        $ppAccount->setDineroAgregado($ppAccount->getDineroAgregado() - $ppAccount->getDineroParaRotar());

        if (!$ppAccount->getActive())
            return false;

        $ppAccNext = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->getNextAccount($ppAccount);
        $ppAccNext->setActive(true);

        $this->em->persist($ppAccNext);
    }

} 