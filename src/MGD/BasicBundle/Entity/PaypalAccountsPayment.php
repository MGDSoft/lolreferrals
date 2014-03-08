<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PaypalAccountsPayment
 *
 * @ORM\Table(name="paypal_accounts_payment")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PaypalAccountsPaymentRepository")
 */
class PaypalAccountsPayment
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
     * @ORM\ManyToOne(targetEntity="Pedido")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id", nullable=true)
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="PaypalAccount", fetch="EAGER")
     * @ORM\JoinColumn(name="paypal_account_id", referencedColumnName="id", nullable=false)
     */
    private $paypalAccount;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float")
     * @Assert\NotBlank()
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

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
     * Set precio
     *
     * @param float $precio
     * @return PaypalAccountsPayment
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Set precio
     *
     * @param float $precio
     * @return PaypalAccountsPayment
     */
    public function setPrecioPaypalNeto($precio)
    {
        $paypal = $precio * (3.4 / 100) + 0.35;
        $this->precio = $precio - $paypal;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return PaypalAccountsPayment
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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return PaypalAccountsPayment
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
     * Set pedido
     *
     * @param \MGD\BasicBundle\Entity\Pedido $pedido
     * @return PaypalAccountsPayment
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
     * Set paypalAccount
     *
     * @param \MGD\BasicBundle\Entity\PaypalAccount $paypalAccount
     * @return PaypalAccountsPayment
     */
    public function setPaypalAccount(\MGD\BasicBundle\Entity\PaypalAccount $paypalAccount = null)
    {
        $this->paypalAccount = $paypalAccount;
    
        return $this;
    }

    /**
     * Get paypalAccount
     *
     * @return \MGD\BasicBundle\Entity\PaypalAccount 
     */
    public function getPaypalAccount()
    {
        return $this->paypalAccount;
    }
}