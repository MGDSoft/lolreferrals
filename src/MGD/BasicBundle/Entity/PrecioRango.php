<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Precio
 *
 * @ORM\Table(name="precio_rango")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PrecioRangoRepository")
 */
class PrecioRango
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
     * @var float
     *
     * @ORM\Column(name="precio", type="float")
     */
    private $precio;

    /**
     * @var float
     *
     * @ORM\Column(name="limite", type="float")
     */
    private $limite;

    public function __toString()
    {
        return $this->precio.' / '.$this->limite;
    }

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
     * Set precio
     *
     * @param float $precio
     * @return PrecioRango
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set limite
     *
     * @param float $limite
     * @return PrecioRango
     */
    public function setLimite($limite)
    {
        $this->limite = $limite;
    
        return $this;
    }

    /**
     * Get limite
     *
     * @return float 
     */
    public function getLimite()
    {
        return $this->limite;
    }
}