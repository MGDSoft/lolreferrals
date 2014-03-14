<?php
/**
 * Created by MGDSoftware. 6/03/14
 */

namespace MGD\BasicBundle\Tests\Entity;

use MGD\BasicBundle\Entity\CuponDescuento;
use MGD\BasicBundle\Entity\Estado;
use MGD\BasicBundle\Entity\PaypalAccount;
use MGD\BasicBundle\Entity\Pedido;
use MGD\BasicBundle\Entity\PedidoEstados;
use MGD\BasicBundle\Entity\PrecioRango;

class TestPedidoHelper
{
    static public function setValues(Pedido $pedido, PrecioRango $precioRango, $nReferidos=5,
        CuponDescuento $cuponDescuento=null, Estado $estado = null, $email='test@test.com',
        $referralLink='http://referidos.com/asdasd/', $refPaypal='asdasd123')
    {

        $pedido
            ->setPrecioRango($precioRango)
            ->setNReferidos($nReferidos)
            ->setEmail($email)
            ->setReferralLink($referralLink)
            ->setRefPaypal($refPaypal)
        ;

        if ($cuponDescuento)
        {
            $pedido->setCuponDescuento($cuponDescuento);
        }

        if ($estado)
        {
            $pedido->setEstado($estado);
        }
    }

} 