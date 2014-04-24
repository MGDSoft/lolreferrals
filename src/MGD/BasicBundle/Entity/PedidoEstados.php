<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PedidoEstados
 *
 * @ORM\Table(name="pedido_estados")
 * @ORM\Entity()
 */
class PedidoEstados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pedido", fetch="EAGER")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="Estado", fetch="EAGER")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $fecha;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return PedidoEstados
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }


    /**
     * Set estado
     *
     * @param \MGD\BasicBundle\Entity\Estado $estado
     *
     * @return PedidoEstados
     */
    public function setEstado(\MGD\BasicBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \MGD\BasicBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set pedido
     *
     * @param \MGD\BasicBundle\Entity\Pedido $pedido
     *
     * @return PedidoEstados
     */
    public function setPedido(\MGD\BasicBundle\Entity\Pedido $pedido = null)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return \MGD\BasicBundle\Entity\Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PedidoEstados
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {

        return $this->fecha;
    }


}