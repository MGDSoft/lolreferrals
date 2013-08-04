<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PedidoRepository")
 */
class Pedido
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
	 * @ORM\ManyToOne(targetEntity="Articulo", fetch="EAGER")
	 * @ORM\JoinColumn(name="articulo_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 */
    private $articulo;
	/**
	 * @ORM\ManyToOne(targetEntity="Estado", fetch="EAGER")
	 * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 */
	private $estado;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=100)
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="referral_link", type="string", length=255,nullable=true)
	 */
	private $referralLink;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ip", type="string", length=39)
	 */
	private $ip;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="ref_paypal", type="string", length=255)
	 */
	private $refPaypal;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fecha", type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	private $fecha;


    /**
     * Constructor
     */
    public function __construct()
    {
	    $this->estado = EstadoEnum::Cola;

	    $this->fecha = new \DateTime();

	    if (isset($_SERVER['REMOTE_ADDR'])) {
		    $this->ip = $_SERVER['REMOTE_ADDR'];
	    }

	    $this->id = uniqid('LOL' . date("Ymdhis"));

    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Pedido
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set refPaypal
     *
     * @param string $refPaypal
     *
     * @return Pedido
     */
    public function setRefPaypal($refPaypal)
    {
        $this->refPaypal = $refPaypal;
    
        return $this;
    }

    /**
     * Get refPaypal
     *
     * @return string 
     */
    public function getRefPaypal()
    {
        return $this->refPaypal;
    }
	


    /**
     * Set articulo
     *
     * @param \MGD\BasicBundle\Entity\Articulo $articulo
     *
     * @return Pedido
     */
    public function setArticulo(\MGD\BasicBundle\Entity\Articulo $articulo = null)
    {
        $this->articulo = $articulo;
    
        return $this;
    }

    /**
     * Get articulo
     *
     * @return \MGD\BasicBundle\Entity\Articulo 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Pedido
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
     * Set estado
     *
     * @param \MGD\BasicBundle\Entity\Estado $estado
     *
     * @return Pedido
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

	public function __toString(){
		return $this->articulo.', '.$this->fecha->format('Y-M-d H:i:s').', '.$this->email
			.', estado Actual: '.$this->estado;
	}

    /**
     * Set email
     *
     * @param string $email
     * @return Pedido
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set referralLink
     *
     * @param string $referralLink
     * @return Pedido
     */
    public function setReferralLink($referralLink)
    {
        $this->referralLink = $referralLink;
    
        return $this;
    }

    /**
     * Get referralLink
     *
     * @return string 
     */
    public function getReferralLink()
    {
        return $this->referralLink;
    }


    /**
     * Set id
     *
     * @param string $id
     * @return Pedido
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
}