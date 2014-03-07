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
use Symfony\Component\Process\Process;
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
     * It cant do flush in events persist or update, this array save entities to persist in event postFlush
     *
     * @var array
     */
    private $postPersist=array();

    /**
     * Required when many entities are persist in the same time, save last Max order
     *
     * @var integer
     */
    private $postPersistOrder;

    /**
     * Required when many entities are persist in the same time, save last active account
     *
     * @var PaypalAccount
     */
    private $postPersistActive;

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
        else if ($this->container->getParameter('paypal_api_username')!=$this->entity->getApiUsername())
        {
            if ($this->modifyApiPayPalAccountParameters($this->entity))
                $this->log->addInfo("Modificado cuenta de paypal para usuario ".$this->entity->getName());
        }

        $this->modifyLastActive();

        $this->postPersistActive = $this->entity;
    }

    private function modifyLastActive()
    {
        if ($this->postPersistActive)
            $ppAccountlastActive=$this->postPersistActive;
        elseif(!$ppAccountlastActive=$this->em->getRepository('MGDBasicBundle:PaypalAccount')->getOneByActive())
            $ppAccountlastActive=null;

        if (!$ppAccountlastActive)
            return true;

        if ($ppAccountlastActive->getApiUsername()==$this->entity->getApiUsername() || !$ppAccountlastActive->getActive())
            return true;

        $ppAccountlastActive->setActive(false);
        $this->postPersist[]=$ppAccountlastActive;
    }

    private function modifyApiPayPalAccountParameters(PaypalAccount $ppAccount)
    {
        // Ugly but necesary...
        if ($this->container->get('kernel')->getEnvironment()=='test')
            return true;

        $parameters = $this->getParameters();

        $parameters['parameters']['paypal_api_username'] = $ppAccount->getApiUsername();
        $parameters['parameters']['paypal_api_password'] = $ppAccount->getApiPassword();
        $parameters['parameters']['paypal_api_signature'] = $ppAccount->getApiSignature();

        if(!$yaml = $this->createYaml($parameters))
            return false;

        if (!file_put_contents($this->parametersFile,$yaml))
            return false;

        $this->clearCache();

        return true;
    }

    private function createYaml(array $parameters)
    {
        $dumper = new Dumper();
        return $dumper->dump($parameters,2,0);
    }

    private function clearCache()
    {
        $process = new Process('php app/console cache:clear --no-optional-warmers --env='.$this->container->get('kernel')->getEnvironment());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    private function getParameters()
    {
        $parser = new Parser();
        return $parser->parse( file_get_contents($this->parametersFile) );
    }

    protected function setOrder()
    {
        if ($this->postPersistOrder)
            $order = $this->postPersistOrder + 1;
        elseif ($order = $this->em->getRepository('MGDBasicBundle:PaypalAccount')->getMaxOrderN())
            $order++;
        else
            $order=1;

        $this->postPersistOrder= $order;
        $this->entity->setOrderN($order);

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