<?php

namespace MGD\BasicBundle\Command;

use Ivory\CKEditorBundle\Exception\Exception;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoBots;
use MGD\BasicBundle\Entity\PrecioRango;
use MGD\BasicBundle\Tests\Entity\TestPedidoHelper;
use MGD\FrameworkBundle\Tests\KernelAwareTest;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class BotsUpdateCommandTest extends KernelAwareTest
{
    /**
     * @var Pedido
     */
    protected $pedido;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures();

        $precioRango = new PrecioRango();
        $precioRango
            ->setLimite(999)
            ->setPrecio(5.2)
        ;

        $this->em->persist($precioRango);
        $this->em->flush();

        $this->pedido = new Pedido();

        TestPedidoHelper::setValues($this->pedido,$precioRango);
    }

    public function testRunOk()
    {
        $this->pedido->addPedidoBot(new PedidoBots($this->pedido,'Trolo'));
        $this->pedido->addPedidoBot(new PedidoBots($this->pedido,'Jacinto'));
        $this->pedido->addPedidoBot(new PedidoBots($this->pedido,'Jose'));
        $this->pedido->addPedidoBot(new PedidoBots($this->pedido,'Manuel'));

        $this->em->persist($this->pedido);
        $this->em->flush();

        $this->createFile('Trolo','Trolo:5');

        $this->executeCommand();

        $repo=$this->em->getRepository("MGDBasicBundle:PedidoBots");
        /** @var PedidoBots $bot */
        $bot= $repo->findOneBy(array('nombre'=>'Trolo'));
        /** @var Pedido $pedido */
        $pedido= $this->em->getRepository("MGDBasicBundle:Pedido")->find($this->pedido->getId());

        $this->assertEquals(5,$bot->getLvl());
        $this->assertEquals(EstadoEnum::Procesando,$pedido->getEstado()->getId());

        $this->createFile('Jacinto','Jacinto:2');
        $this->createFile('Jose','Jose:6');
        $this->createFile('Manuel','Manuel:6');

        $this->executeCommand();

        $this->assertEquals(2,$repo->findOneBy(array('nombre'=>'Jacinto'))->getLvl());
        $this->assertEquals(6,$repo->findOneBy(array('nombre'=>'Jose'))->getLvl());
        $this->assertEquals(6,$repo->findOneBy(array('nombre'=>'Manuel'))->getLvl());

        $this->createFile('Trolo','Trolo:10');
        $this->createFile('Jacinto','Jacinto:10');
        $this->createFile('Jose','Jose:10');
        $this->createFile('Manuel','Manuel:10');

        $this->executeCommand();

        $this->assertEquals(10,$repo->findOneBy(array('nombre'=>'Jacinto'))->getLvl());
        $this->assertEquals(10,$repo->findOneBy(array('nombre'=>'Jose'))->getLvl());
        $this->assertEquals(10,$repo->findOneBy(array('nombre'=>'Manuel'))->getLvl());
        $this->assertEquals(10,$repo->findOneBy(array('nombre'=>'Trolo'))->getLvl());

        $pedido= $this->em->getRepository("MGDBasicBundle:Pedido")->find($this->pedido->getId());
        $this->assertEquals(EstadoEnum::Finalizado,$pedido->getEstado()->getId());
    }

    private function executeCommand()
    {
        $application = new Application($this->kernel);
        $application->add(new BotsUpdateCommand());

        $command = $application->find('bots:scanner');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
    }

    private function createFile($fileName,$fileContent)
    {
        $folder=$this->container->getParameter('bots_updated_dir');
        if (!file_exists($folder))
        {
            if (!mkdir($folder,0777,true))
            {
                throw new Exception("Error al crear la carpeta");
            }
        }

        if (!file_put_contents($folder.'/'.$fileName.'.txt',$fileContent))
        {
            throw new Exception("Error al crear el fichero");
        }
    }


}