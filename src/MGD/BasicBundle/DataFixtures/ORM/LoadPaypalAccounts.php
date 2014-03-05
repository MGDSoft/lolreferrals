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

use MGD\BasicBundle\Entity\PaypalAccount;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadPaypalAccounts extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
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

        $ppAccount=new PaypalAccount();
        $ppAccount
            ->setName("Default")
            ->setActive(true)
            ->setApiUsername($this->container->getParameter("paypal_api_username"))
            ->setApiPassword($this->container->getParameter("paypal_api_password"))
            ->setApiSignature($this->container->getParameter("paypal_api_signature"))
            ->setDineroParaRotar(1000)
        ;
        $manager->persist($ppAccount);

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

