<?php
/**
 * Created by MGDSoftware. 6/03/14
 */

namespace MGD\BasicBundle\Tests\Listener\Entity;


use MGD\BasicBundle\DataConstants\EstadoEnum;
use MGD\BasicBundle\Entity\CuponDescuento;
use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\PaypalAccountsPayment;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PrecioRango;
use MGD\BasicBundle\Tests\Entity\TestPaypalAccountHelper;
use MGD\BasicBundle\Tests\Entity\TestPedidoHelper;
use MGD\FrameworkBundle\Tests\KernelAwareTest;

class PedidoEntityListenerTest extends KernelAwareTest
{

    /**
     * @var PrecioRango
     */
    protected $precioRango = null;


    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures();

        $this->precioRango = new PrecioRango();
        $this->precioRango
            ->setLimite(999)
            ->setPrecio(5.2)
        ;

        $this->em->persist($this->precioRango);
    }

    public function testCalculatePriceOK()
    {
        $pedido = new Pedido();

        TestPedidoHelper::setValues($pedido,$this->precioRango,2);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertEquals(10.4, $pedido->getTotal());
    }

    public function testCalculatePriceWithDiscountOK()
    {
        $cuponDescuento = new CuponDescuento();

        $cuponDescuento
            ->setNUsos(2)
            ->setPorcentajeBoo(false)
            ->setValor(5.3)
        ;
        $this->em->persist($cuponDescuento);
        $this->em->flush();

        $pedido = new Pedido();

        TestPedidoHelper::setValues($pedido,$this->precioRango,2,$cuponDescuento);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertEquals(5.1, $pedido->getTotal());
    }

    public function testInsertOk()
    {
        $estadoProceso = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Procesando);

        $pedido = new Pedido();

        TestPedidoHelper::setValues($pedido,$this->precioRango,2);

        $pedido->setEstado($estadoProceso);
        $this->em->persist($pedido);
        $this->em->flush();

        $pedido = $this->em->getRepository('MGDBasicBundle:Pedido')->find($pedido->getId());

        $this->assertEquals(EstadoEnum::Procesando, $pedido->getEstado()->getId());
    }

    public function testAddStateOK()
    {
        $pedido = new Pedido();

        TestPedidoHelper::setValues($pedido,$this->precioRango,2);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertEquals(EstadoEnum::Cola, $pedido->getEstado()->getId());

        $pedido->setEmail('email@changed.com');
        $this->em->persist($pedido);
        $this->em->flush();

        $pedido = $this->em->getRepository('MGDBasicBundle:Pedido')->find($pedido->getId());
        $this->assertEquals(EstadoEnum::Cola, $pedido->getEstado()->getId());

        $estados = $this->em->getRepository('MGDBasicBundle:PedidoEstados')->findByPedido($pedido);
        $this->assertEquals(1, count($estados));
        $this->assertEquals('email@changed.com', $pedido->getEmail());
        $this->assertEquals(EstadoEnum::Cola, $pedido->getEstado()->getId());

        $estadoProceso = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Procesando);
        $pedido->setEstado($estadoProceso);
        $this->em->persist($pedido);
        $this->em->flush();

        $estados = $this->em->getRepository('MGDBasicBundle:PedidoEstados')->findByPedido($pedido);
        $this->assertEquals(2, count($estados));
        $this->assertEquals(EstadoEnum::Procesando, $pedido->getEstado()->getId());

        $estadoFinalizado = $this->em->getRepository('MGDBasicBundle:Estado')->find(EstadoEnum::Finalizado);
        $pedido->setEstado($estadoFinalizado);
        $this->em->persist($pedido);
        $this->em->flush();

        $estados = $this->em->getRepository('MGDBasicBundle:PedidoEstados')->findByPedido($pedido);
        $this->assertEquals(3, count($estados));
        $this->assertEquals(EstadoEnum::Finalizado, $pedido->getEstado()->getId());

        $pedido = $this->em->getRepository('MGDBasicBundle:Pedido')->find($pedido->getId());
        $this->assertEquals(EstadoEnum::Finalizado, $pedido->getEstado()->getId());
    }

    public function testModifyPaypalAccountsOK()
    {
        $ppAcc= new PaypalAccount();

        TestPaypalAccountHelper::setValues($ppAcc,true);

        $this->em->persist($ppAcc);
        $this->em->flush();

        $pedido = new Pedido();
        TestPedidoHelper::setValues($pedido,$this->precioRango, 2);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertEquals(10.4, $pedido->getTotal());
        $this->assertEquals(10.4, $ppAcc->getDineroAgregado());
        $this->assertEquals(10.4, $ppAcc->getDineroAgregadoTotal());

        $pedido->setNReferidos(1);

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertEquals(5.2, $pedido->getTotal());
        $this->assertEquals(5.2, $ppAcc->getDineroAgregado());
        $this->assertEquals(5.2, $ppAcc->getDineroAgregadoTotal());
    }


}