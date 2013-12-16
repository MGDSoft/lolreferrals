<?php
/**
 * Created by lol.
 * User: PC
 * Date: 27/07/13
 * Time: 17:23
 */

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use \MGD\FrameworkBundle\Entity\Rol;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadRolData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{


		$roles = array(
			array('nombre' => 'ROLE_SUPER_ADMIN'),
			array('nombre' => 'ROLE_EDITOR')
		);

		foreach ($roles as $rol) {
			$entidad = new Rol();

			$entidad->setName($rol['nombre']);
			$manager->persist($entidad);

			$this->addReference('admin-rol-'.$rol['nombre'], $entidad);
		}
		$manager->flush();

	}

	public function getOrder()
	{
		return 1; // the order in which fixtures will be loaded
	}
}

