<?php
/**
 * Created by lol.
 * User: PC
 * Date: 20/11/13
 * Time: 14:12
 */

namespace MGD\BasicBundle\Command;

use Doctrine\ORM\EntityManager;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoBots;
use MGD\BasicBundle\Entity\PedidoEstados;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class BotsUpdateCommand extends ContainerAwareCommand
{
    /** @var EntityManager */
    private $em;
    /** @var LoggerInterface */
    private $logger;

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
        $this->em = $container->get("doctrine")->getManager();

        $this->logger = $container->get('logger');

        $dir = $container->getParameter('bots_updated_dir').DIRECTORY_SEPARATOR;

        foreach (glob("$dir*.txt") as $file)
        {
            $fileArr=explode(':',trim(file_get_contents($file)));

            if (count($fileArr)!=2)
            {
                $this->logger->critical("El fichero $file no contiene 2 valores");
                continue;
            }

            $nombre=$fileArr[0];
            $lvl=$fileArr[1];

            /** @var PedidoBots $pedidoBot */
            if (!$pedidoBot = $this->em->getRepository("MGDBasicBundle:PedidoBots")->findOneByNombre($nombre))
            {
                $this->logger->error("No se ha encontrado el bot con nombre $nombre");
                continue;
            }

            $pedidoBot->setLvl($lvl);
            $this->logger->debug("Actualizado el bot $nombre al nivel $lvl");

            unlink($file);

            $this->em->flush();

            if (isset($pedidoBot))
            {
                $this->siPedidoFinalizadoCambiarEstado($pedidoBot);
                $this->siPedidoElPrimeroCambiarEstado($pedidoBot);
            }
        }

    }

    private function siPedidoFinalizadoCambiarEstado(PedidoBots $pedidoBot)
    {
        $pedido = $pedidoBot->getPedido();

        if ($pedidoBot && $this->em->getRepository('MGDBasicBundle:PedidoBots')->isCompletedByPedido($pedido))
        {
            $estadoFinalizado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Finalizado);
            $pedido->setEstado($estadoFinalizado);

            $this->changeState($pedido,$estadoFinalizado);
        }
    }

    private function siPedidoElPrimeroCambiarEstado(PedidoBots $pedidoBot)
    {
        $pedido = $pedidoBot->getPedido();

        if ($pedidoBot
            && $pedido->getEstado()->getId() == EstadoEnum::Cola
            && $this->em->getRepository('MGDBasicBundle:PedidoBots')->countMayorLvlByPedido($pedido, 0) > 0 )
        {
            $estadoFinalizado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Procesando);
            $pedido->setEstado($estadoFinalizado);

            $this->changeState($pedido,$estadoFinalizado);
        }
    }

    private function changeState(Pedido $pedido,Estado $estado)
    {
        $pedido->setEstado($estado);

        $pedidoEstado  = new PedidoEstados();
        $pedidoEstado->setEstado($estado);
        $pedidoEstado->setPedido($pedido);

        $this->em->persist($pedidoEstado);
        $this->em->flush();
    }

}