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
use MGD\BasicBundle\Entity\PrecioRango;

class TestData extends AbstractFixture implements OrderedFixtureInterface
{
    const pedidoId = "REFLOL12345";
    const email = "prueba@prueba.com";
    /**
     * {@inheritDoc}
     */
	public function load(ObjectManager $manager)
    {
        /*
        $articulo = new Articulo();

        $articulo->setImagenPath("");
        $articulo->setNombre("Pedido 1");
        $articulo->setPrecio("500$");

        $manager->persist($articulo);
        */

        /*$precioRango = new PrecioRango();
        $precioRango->setPrecio(5.2);
        $precioRango->setLimite(999);

        $manager->persist($precioRango);

        $pedido = new Pedido();
        $pedido->setNReferidos(10);
        $pedido->setId(self::pedidoId);
        $pedido->setPrecioRango($precioRango);
        //$pedido->setArticulo($articulo);
        $pedido->setRefPaypal("RE123435ASd");

        $pedido->setEmail(self::email);

        $manager->persist($pedido);
        $manager->flush();*/
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 99; // the order in which fixtures will be loaded
    }
}

