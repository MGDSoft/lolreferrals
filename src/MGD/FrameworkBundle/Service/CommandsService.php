<?php
/**
 * Created by lol.
 * User: PC
 * Date: 13/12/13
 * Time: 7:45
 */

namespace MGD\FrameworkBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Process\Process;

class CommandsService
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $rootDir;

    function __construct(Container $container)
    {
        $this->container = $container;
        $this->kernel = $this->container->get('kernel');
        $this->rootDir = $this->kernel->getRootDir();
    }

    function clearCache()
    {
        $commandString='php '.$this->rootDir.'/console cache:clear --no-optional-warmers --env='.$this->kernel->getEnvironment();

        $process = new Process($commandString);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

}