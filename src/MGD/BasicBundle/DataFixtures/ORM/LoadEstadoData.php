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
use \MGD\BasicBundle\DataConstants\EstadoEnum;
use \MGD\BasicBundle\Entity\Estado;

class LoadUsuariosData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$estados = array(
			array('nombre'=>'Cola'),
			array('nombre'=>'Espera'),
			array('nombre'=>'Fallo'),
			array('nombre'=>'Proceso'),
			array('nombre'=>'Finalizado'),
		);

		foreach ($estados as $estado) {

			$entidad = new Estado();

			$entidad->setNombre($estado['nombre']);

			$manager->persist($entidad);
		}
		$manager->flush();

	}

	public function getOrder()
	{
		return 10; // the order in which fixtures will be loaded
	}
}

