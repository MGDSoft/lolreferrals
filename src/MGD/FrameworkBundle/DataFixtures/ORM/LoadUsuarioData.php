<?php
/**
 * Created by lol.
 * User: PC
 * Date: 27/07/13
 * Time: 17:23
 */

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \MGD\FrameworkBundle\Entity\Usuario;
use \MGD\FrameworkBundle\Entity\Rol;

class LoadUsuarioData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$usuarios = array();

		$roleSuperAdmin = $this->getReference('admin-rol-ROLE_SUPER_ADMIN');
		$roleEditor = $this->getReference('admin-rol-ROLE_EDITOR');

		$usuarios[]=$this->add('miguel','TmQrU4XE2kSL6v4/adg8EmQ0o7H0YVXF5VMnqQCaeaQvRz61hn6Vby7w15Xg+obB9C2LXmLpZmDefEXb5aiyjg==','8c735ce5c832f0cd0fc6ea88a30ca7a2',$roleSuperAdmin);
		$usuarios[]=$this->add('editor','aOLjhn+DoLb06lkh04kk9OOg0nitUWWv7HR88Gy+b/UTAhcwxHqEBajNQXWfBpG3xPZOrIFpmdqLC/klKyNbaQ==','f344fce07bdef1a445f5fa82c7429de8',$roleEditor);

		foreach ($usuarios as $usuario) {
			$entidad = new Usuario();

			$entidad->setSalt($usuario['salt']);
			$entidad->setUsername($usuario['username']);
			$entidad->setPassword($usuario['password']);
			$entidad->addRol($usuario['rol']);

			$manager->persist($entidad);
		}
		$manager->flush();

	}

	private function add ($username,$password,$salt,Rol $rol)
	{
		return array('username' => $username,'password' => $password,'salt' => $salt, 'rol' => $rol);
	}

	public function getOrder()
	{
		return 5; // the order in which fixtures will be loaded
	}
}

