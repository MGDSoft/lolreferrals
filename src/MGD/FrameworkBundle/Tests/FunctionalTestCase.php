<?php
/**
 * Created by lol.
 * User: PC
 * Date: 17/08/13
 * Time: 21:14
 */

namespace MGD\FrameworkBundle\Tests;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Router;

abstract class FunctionalTestCase extends WebTestCase {

    /** @var Client */
    protected $client;

    /** @var Router */
    protected $router;

    /** @var ObjectManager */
    protected $om;

    /** @var ContainerInterface */
    protected $container;

    /** @var Application */
    protected static $application;

    protected static function initialize() {
        self::createClient();
        $application = new Application(static::$kernel);

        $application->setAutoExit(false);

        self::createDatabase($application);
        self::$application = $application;
    }

    private static function createDatabase($application) {
        echo "Creando BD ... \n";
        self::executeCommand($application, "doctrine:schema:drop", array("--force" => true , "--env"=>'test'));
        self::executeCommand($application, "doctrine:database:create", array("--env" => 'test'));
        self::executeCommand($application, "doctrine:schema:create", array("--env" => 'test'));
        self::executeCommand($application, "doctrine:fixtures:load", array("-n" => true, "--env"=>'test'));
        //self::executeCommand($application, "doctrine:fixtures:load", array("--fixtures" => __DIR__ . "/../DataFixtures/ORM/test", "-n" => true));
        echo "Finalizado creacion de BD \n";
    }

    private static function loadFixtures($FileToLoad){
        self::executeCommand(self::$application, "doctrine:fixtures:load", array("--fixtures" => $FileToLoad, "-n" => true));
    }

    private static function executeCommand($application, $command, Array $options = array()) {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $application->run(new ArrayInput($options));
    }

    public function setUp() {
        $this->populateVariables();
    }

    protected function populateVariables() {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $this->client->enableProfiler();

        $container = static::$kernel->getContainer();

        $this->om = $container->get('doctrine');
        $this->router = $container->get('router');

        $this->container = $container;
    }

    protected function mostrarHtml($crawler)
    {
        $html = '';

        foreach ($crawler as $domElement) {
            $html.= $domElement->ownerDocument->saveHTML();
        }

        echo $html;

    }

}