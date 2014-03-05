<?php
/**
 * Created by MGDSoftware. 4/03/14
 */

namespace MGD\BasicBundle\Listener\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use MGD\BasicBundle\Entity\PaypalAccount;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;


class PaypalAccountEntityListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Logger
     */
    protected $log;

    /**
     * @var String
     */
    private $parametersFile;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var PaypalAccount
     */
    private $entity;

    /**
     * @var array
     */
    private $postPersist=array();

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->parametersFile = $this->container->get('kernel')->getRootDir(). '/config/parameters.yml';
        $this->log = $container->get('logger');
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        if (!$this->setUp($args))
            return false;

        $this->uniqueActive();

    }

    public  function prePersist(LifecycleEventArgs $args)
    {
        if (!$this->setUp($args))
            return false;

        $this->uniqueActive();
        $this->setOrder();
    }

    private function setUp(LifecycleEventArgs $args)
    {
        $this->entity = $args->getEntity();
        $this->em = $args->getEntityManager();

        if (!$this->entity instanceof PaypalAccount)
            return false;

        return true;
    }

    protected function uniqueActive()
    {
        if (!$this->entity->getActive())
            return true;
        else
            if ($this->modifyApiPayPalAccountParameters($this->entity))
                $this->log->addInfo("Modificado cuenta de paypal para usuario ".$this->entity->getName());

        if(!$ppAccountlastActive=$this->em->getRepository('MGDBasicBundle:PaypalAccount')->getOneByActive())
            return true;

        if ($ppAccountlastActive->getApiUsername()==$this->entity->getApiUsername() || !$ppAccountlastActive->getActive())
            return true;

        $ppAccountlastActive->setActive(false);
        $this->postPersist[]=$ppAccountlastActive;

    }

    private function modifyApiPayPalAccountParameters(PaypalAccount $ppAccount)
    {
        $parameters = $this->getParameters();

        $parameters['parameters']['paypal_api_username'] = $ppAccount->getApiUsername();
        $parameters['parameters']['paypal_api_password'] = $ppAccount->getApiPassword();
        $parameters['parameters']['paypal_api_signature'] = $ppAccount->getApiSignature();

        if(!$yaml = $this->createYaml($parameters))
            return false;

        if (!file_put_contents($this->parametersFile,$yaml))
            return false;

        return true;
    }

    private function createYaml(array $parameters)
    {
        $dumper = new Dumper();
        return $dumper->dump($parameters,2,0);
    }

    private function getParameters()
    {
        $parser = new Parser();
        return $parser->parse( file_get_contents($this->parametersFile) );
    }

    protected function setOrder()
    {
        if ($nextAcc = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->getMaxOrder($this->entity))
            $order=$nextAcc->getOrder()+1;
        else
            $order=1;

        $this->entity->setOrder($order);
    }

    /**
     * Create to do a flush
     *
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        if ($this->postPersist)
        {
            $em=$args->getEntityManager();

            foreach ($this->postPersist as $obj)
                $em->persist($obj);

            $em->flush();
        }

        $this->needsFlush = false;
    }
} 