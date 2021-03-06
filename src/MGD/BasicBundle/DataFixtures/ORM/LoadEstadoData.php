<?php

namespace MGD\BasicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \MGD\BasicBundle\DataConstants\EstadoEnum;
use \MGD\BasicBundle\Entity\Estado;

class LoadEstadoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $estados = array(
            array('nombre' => 'Queue'),
            array('nombre' => 'Waiting'),
            array('nombre' => 'Failed'),
            array('nombre' => 'Leveling accounts'),
            array('nombre' => 'Completed'),
        );

        foreach ($estados as $estado) {

            $entidad = new Estado();

            $entidad->setNombre($estado['nombre']);

            $manager->persist($entidad);
        }
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10; // the order in which fixtures will be loaded
    }
}

