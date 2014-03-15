<?php

namespace MGD\BasicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Articulo;
use \MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\BasicBundle\Entity\PrecioRango;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPaypalAccount extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const NAME = "Default-TEST";
    const DINERO_PARA_ROTAR = 1000;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
	public function load(ObjectManager $manager)
    {

        $ppA = new PaypalAccount();

        if ($this->container)
        {
            $apiUser=$this->container->getParameter('paypal_api_username');
            $apiPassword=$this->container->getParameter('paypal_api_password');
            $apiSignature=$this->container->getParameter('paypal_api_signature');
        }else{
            // Loading testing
            $apiUser='UserTest';
            $apiPassword='PassTest';
            $apiSignature='SignTest';
        }

        $ppA
            ->setActive(true)
            ->setName(self::NAME)
            ->setApiUsername($apiUser)
            ->setApiPassword($apiPassword)
            ->setApiSignature($apiSignature)
            ->setDineroParaRotar(self::DINERO_PARA_ROTAR)
        ;

        $manager->persist($ppA);
        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}

