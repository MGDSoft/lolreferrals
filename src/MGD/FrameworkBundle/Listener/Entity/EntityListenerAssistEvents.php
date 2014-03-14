<?php
/**
 * Created by MGDSoftware. 13/03/14
 */

namespace MGD\FrameworkBundle\Listener\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;

abstract class EntityListenerAssistEvents
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\UnitOfWork
     */
    protected $uow;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadataFactory
     */
    protected $cmf;

    protected function setUpFlush(OnFlushEventArgs $args)
    {
        $this->em = $args->getEntityManager();
        $this->uow = $this->em->getUnitOfWork();
        $this->cmf = $this->em->getMetadataFactory();
    }

    protected function persistOnFlush($obj)
    {
        $this->em->persist($obj);
        $this->saveEntityOnFlush($obj);
    }

    protected function saveEntityOnFlush($obj)
    {
        $metaObj     = $this->cmf->getMetadataFor(get_class($obj));
        $this->uow->computeChangeSet($metaObj, $obj);
    }

    protected function persistSingleOnFlush($obj)
    {
        $this->em->persist($obj);
        $this->saveSingleEntityOnFlush($obj);
    }

    protected function saveSingleEntityOnFlush($obj)
    {
        $metaObj     = $this->cmf->getMetadataFor(get_class($obj));
        $this->uow->recomputeSingleEntityChangeSet($metaObj, $obj);
    }
} 