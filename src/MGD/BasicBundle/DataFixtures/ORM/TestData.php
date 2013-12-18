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
use MGD\BasicBundle\Entity\Articulo;
use \MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;

class TestData extends AbstractFixture implements OrderedFixtureInterface
{
    const pedidoId = "REFLOL12345";
    const email = "prueba@prueba.com";

	public function load(ObjectManager $manager)
	{
        $articulo = new Articulo();

        $articulo->setImagenPath("");
        $articulo->setNombre("Pedido 1");
        $articulo->setPrecio("500$");

        $manager->persist($articulo);

        $estado = $manager->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Cola);

        $pedido = new Pedido();
        $pedido->setId(self::pedidoId);
        $pedido->setArticulo($articulo);
        $pedido->setRefPaypal("RE123435ASd");
        $pedido->setTotal(25);
        $pedido->setEmail(self::email);
        $pedido->setEstado($estado);

        $manager->persist($pedido);

        $pedidoEstado= new PedidoEstados();
        $pedidoEstado->setPedido($pedido);
        $pedidoEstado->setDescripcion("desc");
        $pedidoEstado->setEstado($estado);

        $manager->persist($pedidoEstado);

        $manager->flush();

	}

	public function getOrder()
	{
		return 99; // the order in which fixtures will be loaded
	}
}

