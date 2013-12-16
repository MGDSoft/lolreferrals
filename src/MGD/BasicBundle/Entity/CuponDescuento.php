<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * CuponDescuento
 *
 * @ORM\Table(name="cupon_descuento")
 * @ORM\Entity
 * @ExclusionPolicy("None")
 */
class CuponDescuento
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="float")
     * @Assert\NotBlank()
     */
    private $valor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="porcentaje_boo", type="boolean")
     */
    private $porcentajeBoo=false;

    /**
     * @var integer
     *
     * @ORM\Column(name="n_usos", type="integer")
     * @Assert\NotBlank()
     */
    private $nUsos=1;

    /**
     * @var integer
     *
     * @ORM\Column(name="n_usados", type="integer")
     */
    private $nUsados=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiracion_date", type="datetime")
     * @Assert\NotBlank()
     */
    private $expiracionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $creadoDate;


    function __construct()
    {
        $this->expiracionDate = new \DateTime('+6 month');
        $this->id = uniqid('COD' . date("Ymdhis"));
    }

    public function __toString()
    {
        return $this->valor . ($this->porcentajeBoo ? "%" : "&euro;" );
    }


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valor
     *
     * @param float $valor
     * @return CuponDescuento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return float 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set porcentajeBoo
     *
     * @param boolean $porcentajeBoo
     * @return CuponDescuento
     */
    public function setPorcentajeBoo($porcentajeBoo)
    {
        $this->porcentajeBoo = $porcentajeBoo;
    
        return $this;
    }

    /**
     * Get porcentajeBoo
     *
     * @return boolean 
     */
    public function getPorcentajeBoo()
    {
        return $this->porcentajeBoo;
    }

    /**
     * Set nUsos
     *
     * @param integer $nUsos
     * @return CuponDescuento
     */
    public function setNUsos($nUsos)
    {
        $this->nUsos = $nUsos;
    
        return $this;
    }

    /**
     * Suma Uso
     *
     * @return CuponDescuento
     */
    public function sumaUso()
    {
        $this->nUsados++;

        return $this;
    }

    /**
     * Get nUsos
     *
     * @return integer 
     */
    public function getNUsos()
    {
        return $this->nUsos;
    }

    /**
     * Set expiracionDate
     *
     * @param \DateTime $expiracionDate
     * @return CuponDescuento
     */
    public function setExpiracionDate( $expiracionDate)
    {
        $this->expiracionDate = $expiracionDate;
    
        return $this;
    }

    /**
     * Get expiracionDate
     *
     * @return \DateTime 
     */
    public function getExpiracionDate()
    {
        return $this->expiracionDate;
    }

    /**
     * Set nUsados
     *
     * @param integer $nUsados
     * @return CuponDescuento
     */
    public function setNUsados($nUsados)
    {
        $this->nUsados = $nUsados;
    
        return $this;
    }

    /**
     * Get nUsados
     *
     * @return integer 
     */
    public function getNUsados()
    {
        return $this->nUsados;
    }

    /**
     * Get creadoDate
     *
     * @return \DateTime
     */
    public function getCreadoDate()
    {
        return $this->creadoDate;
    }

    public function validarCupon()
    {
        if ($this->getNUsados() >= $this->getNUsos())
        {
            return false;
        }

        if ($this->getExpiracionDate()->getTimestamp() <= time())
        {
            return false;
        }

        return true;
    }
}