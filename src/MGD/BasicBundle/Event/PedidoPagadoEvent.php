<?php
/**
 * Created by lol.
 * User: PC
 * Date: 2/08/13
 * Time: 1:10
 */

namespace MGD\BasicBundle\Event;

use MGD\BasicBundle\Entity\Pedido;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\Event;

class PedidoPagadoEvent extends Event {

    /**
     * @var Pedido
     */
    protected  $pedido;

    function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * @param mixed $pedido
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * @return Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

}