<?php

namespace MGD\BasicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Articulo;
use \MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\BasicBundle\Entity\PrecioRango;

class LoadTestData extends AbstractFixture implements OrderedFixtureInterface
{
    const PEDIDO_ID = "REFLOL12345";
    const EMAIL = "prueba@prueba.com";
    const TOTAL_N_REFERIDOS = 151;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        /*$articulo = new Articulo();

        $articulo->setImagenPath("");
        $articulo->setNombre("Pedido 1");
        $articulo->setPrecio("500$");

        $manager->persist($articulo);*/


        $precioRango = new PrecioRango();
        $precioRango->setPrecio(5.2);
        $precioRango->setLimite(999);

        $manager->persist($precioRango);

        $pedido = new Pedido();
        $pedido->setNReferidos(self::TOTAL_N_REFERIDOS);
        $pedido->setId(self::PEDIDO_ID);
        $pedido->setPrecioRango($precioRango);
        //$pedido->setArticulo($articulo);
        $pedido->setRefPaypal("RE123435ASd");

        $pedido->setEmail(self::EMAIL);

        $manager->persist($pedido);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 99; // the order in which fixtures will be loaded
    }
}

