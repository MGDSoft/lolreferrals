<?php

namespace MGD\FrameworkBundle\Tests;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Process\Process;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

require_once dirname(__DIR__).'/../../../app/AppKernel.php';

/**
 * Test case class helpful with Entity tests requiring the database interaction.
 * For regular entity tests it's better to extend standard \PHPUnit_Framework_TestCase instead.
 */
abstract class KernelAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppKernel
     */
    protected $kernel;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @return null
     */
    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();

        $this->generateSchema();

        parent::setUp();
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        $this->kernel->shutdown();

        parent::tearDown();
    }

    /**
     * @return null
     */
    protected function generateSchema()
    {
        $metadatas = $this->getMetadatas();

        if (!empty($metadatas)) {
            $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
            $tool->dropSchema($metadatas);
            $tool->createSchema($metadatas);
        }
    }

    /**
     * @return array
     */
    protected function getMetadatas()
    {
        return $this->em->getMetadataFactory()->getAllMetadata();
    }

    /**
     * Load and execute fixtures from a main bundle
     *
     */
    protected function loadFixturesGeneral()
    {
        $this->loadFixturesFromDirectory( __DIR__.'/../../BasicBundle/DataFixtures/ORM');
    }

    /**
     * Load and execute fixtures from a directory
     *
     * @param string $directory
     *
     */
    protected function loadFixturesFromDirectory($directory)
    {
        $loader = new Loader();
        $loader->loadFromDirectory($directory);
        $this->executeFixtures($loader);
    }

    /**
     * One Fixture
     *
     * @param FixtureInterface $fix
     */
    protected function loadFixture(FixtureInterface $fix)
    {
        $loader = new Loader();
        $loader->addFixture($fix);
        $this->executeFixtures($loader);
    }


    /**
     * Executes fixtures
     *
     * @param \Doctrine\Common\DataFixtures\Loader $loader
     */
    protected function executeFixtures(Loader $loader)
    {
        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }

    private  function executeCommand($command)
    {
        $process = new Process("php ".$this->kernel->getRootDir() ."/console $command --env=test ");
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

}