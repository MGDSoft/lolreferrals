<?php
/**
 * Created by lol.
 * User: PC
 * Date: 27/07/13
 * Time: 17:23
 */
namespace MGD\BasicBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use MGD\BasicBundle\Entity\Cola;


class LoadColaData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
        $cola=new Cola();
        $cola->setDays(2);
        $cola->setText("");

        $manager->persist($cola);

		$manager->flush();
	}



	public function getOrder()
	{
		return 20; // the order in which fixtures will be loaded
	}
}

