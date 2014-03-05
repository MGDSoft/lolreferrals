<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Util\SecureRandom;
use MGD\BasicBundle\Entity\BotCuenta;

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
	 * @ORM\JoinColumn(name="articulo_id", referencedColumnName="id", nullable=false)
	 */
    private $articulo;

	/**
	 * @ORM\ManyToOne(targetEntity="Estado", fetch="EAGER")
	 * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=true)
	 */
	private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="CuponDescuento", fetch="EAGER")
     * @ORM\JoinColumn(name="cupon_id", referencedColumnName="id", nullable=true)
     */
    private $cuponDescuento;

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
     * @var PedidoBots[]
     *
     * @ORM\OneToMany(targetEntity="PedidoBots", mappedBy="pedido", cascade={"remove"}, orphanRemoval=true)
     */
    private $pedidoBots;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ip", type="string", length=39)
	 */
	private $ip;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="ref_paypal", type="string", length=255,nullable=true)
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
     * @var PaymentInstruction
     *
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction" , cascade={"remove"}, orphanRemoval=true)
     */
    private $paymentInstruction;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    private $total;

    /**
     * Constructor
     */
    public function __construct()
    {
	    $this->estado = EstadoEnum::Cola;

	    $this->fecha = new \DateTime();

	    if (isset($_SERVER['REMOTE_ADDR'])) {
		    $this->ip = $_SERVER['REMOTE_ADDR'];
	    }else{
            $this->ip = "CLI";
        }

	    $this->id = uniqid('LOL' . date("Ymdhis"));


        $this->pedidoBots = new \Doctrine\Common\Collections\ArrayCollection();
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
			.', estado Actual: '.$this->estado.($this->cuponDescuento ? ", Descuento: ".$this->cuponDescuento: "");
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



    /**
     * Set paymentInstruction
     *
     * @param \JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction
     * @return Pedido
     */
    public function setPaymentInstruction(\JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction = null)
    {
        $this->paymentInstruction = $paymentInstruction;
    
        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return \JMS\Payment\CoreBundle\Entity\PaymentInstruction 
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }



    /**
     * Set total
     *
     * @param float $total
     * @return Pedido
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set cuponDescuento
     *
     * @param CuponDescuento $cuponDescuento
     * @return Pedido
     */
    public function setCuponDescuento(CuponDescuento $cuponDescuento)
    {
        $this->cuponDescuento = $cuponDescuento;
    
        return $this;
    }

    /**
     * Get cuponDescuento
     *
     * @return CuponDescuento
     */
    public function getCuponDescuento()
    {
        return $this->cuponDescuento;
    }

    /**
     * @param \MGD\BasicBundle\Entity\PedidoBots[] $pedidoBots
     */
    public function setPedidoBots($pedidoBots)
    {
        $this->pedidoBots = $pedidoBots;
    }

    /**
     * @return \MGD\BasicBundle\Entity\PedidoBots[]
     */
    public function getPedidoBots()
    {
        return $this->pedidoBots;
    }

    public function getPedidoBotsState()
    {
        if ($this->pedidoBots->count()>0)
        {
            $esperando=$finalizado=$corriendo=0;
            foreach ($this->pedidoBots as $bot)
            {
                if ($bot->getLvl()==10)
                    $finalizado++;
                elseif ($bot->getLvl()!=0)
                    $corriendo++;
                else
                    $esperando++;
            }

            return "q-$esperando<br>lvl-$corriendo<br>comp-$finalizado";
        }

        return false;
    }

    /**
     * Add pedidoBots
     *
     * @param \MGD\BasicBundle\Entity\PedidoBots $pedidoBots
     * @return Pedido
     */
    public function addPedidoBot(\MGD\BasicBundle\Entity\PedidoBots $pedidoBots)
    {
        $this->pedidoBots[] = $pedidoBots;
    
        return $this;
    }

    /**
     * Remove pedidoBots
     *
     * @param \MGD\BasicBundle\Entity\PedidoBots $pedidoBots
     */
    public function removePedidoBot(\MGD\BasicBundle\Entity\PedidoBots $pedidoBots)
    {
        $this->pedidoBots->removeElement($pedidoBots);
    }
}