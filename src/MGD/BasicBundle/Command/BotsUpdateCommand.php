<?php
/**
 * Created by lol.
 * User: PC
 * Date: 20/11/13
 * Time: 14:12
 */

namespace MGD\BasicBundle\Command;

use MGD\BasicBundle\Entity\PedidoBots;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class BotsUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bots:scanner')
            ->setDescription('Actualiza el nivel de los bots, leyendo archivos de una carpeta.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get("doctrine")->getManager();
        /** @var $logger LoggerInterface */
        $logger = $container->get('logger');

        $dir = $container->getParameter('bots_updated_dir').DIRECTORY_SEPARATOR;

        foreach (glob("$dir*.txt") as $file)
        {
            $fileArr=explode(':',trim(file_get_contents($file)));

            if (count($fileArr)!=2)
            {
                $logger->critical("El fichero $file no contiene 2 valores");
                continue;
            }

            $nombre=$fileArr[0];
            $lvl=$fileArr[1];

            /** @var PedidoBots $pedidoBot */
            if (!$pedidoBot = $em->getRepository("MGDBasicBundle:PedidoBots")->findOneByNombre($nombre))
            {
                $logger->error("No se ha encontrado el bot con nombre $nombre");
                continue;
            }

            $pedidoBot->setLvl($lvl);
            $logger->debug("Actualizado el bot $nombre al nivel $lvl");

            unlink($file);
        }

        $em->flush();
    }
}