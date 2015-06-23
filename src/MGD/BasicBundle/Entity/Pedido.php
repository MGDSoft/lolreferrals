<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MGD\BasicBundle\DataConstants\EstadoEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PedidoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Pedido extends AbstractPrice
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
     * @ORM\ManyToOne(targetEntity="PrecioRango", fetch="EAGER")
     * @ORM\JoinColumn(name="precio_rango_id", referencedColumnName="id", nullable=true)
     */
    private $precioRango;

    /**
     * @var string
     *
     * @ORM\Column(name="n_referidos", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min = 3, max = 5)
     */
    private $nReferidos;

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
     * @var \MGD\BasicBundle\Entity\Cuenta
     *
     * @ORM\ManyToOne(targetEntity="MGD\BasicBundle\Entity\Cuenta", fetch="EAGER")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=true)
     */
    private $cuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="referral_link", type="string", length=255,nullable=true)
     * @Assert\NotBlank()
     */
    private $referralLink;

    /**
     * @var PedidoBots[]
     *
     * @ORM\OneToMany(targetEntity="PedidoBots", mappedBy="pedido", cascade={"remove","persist"}, orphanRemoval=true)
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
     */
    private $fecha;

    /**
     * @var PaymentInstruction
     *
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction" , cascade={"remove"}, orphanRemoval=true)
     */
    private $paymentInstruction;

    /**
     * @var \MGD\BasicBundle\Entity\ObjetoExtra
     *
     * @ORM\ManyToMany(targetEntity="MGD\BasicBundle\Entity\ObjetoExtra",cascade={"persist"})
     * @ORM\JoinTable(name="pedido_has_objetos_extras")
     */
    private $objetosExtras;

    /**
     * @var PedidoOpinion
     *
     * @ORM\OneToOne(targetEntity="PedidoOpinion", mappedBy="pedido", cascade={"remove"}, orphanRemoval=true)
     */
    private $opinion;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    private $language='en';

    /**
     * dynamically generated nQueueReferralsRemaining / referralsPerDay
     *
     * @var int
     */
    private $queueRemainingDays;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fecha = new \DateTime();

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        } else if (php_sapi_name() == "cli") {
            $this->ip = "CLI";
        } else {
            $this->ip = "UNKNOWN";
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

    public function __toString()
    {
        return $this->nReferidos . ' refs ' . $this->total . 'eur, ' . $this->fecha->format(
            'Y-M-d H:i:s'
        ) . ', ' . $this->email . ', estado Actual: ' . $this->estado . ($this->cuponDescuento ? ", Descuento: " . $this->cuponDescuento : "");
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

    /**
     * Set precio
     *
     * @return float
     */
    public function getPrecioPaypalNeto()
    {
        $paypal = $this->total * (3.4 / 100) + 0.35;
        return number_format($this->total - $paypal, 2, '.', '');

    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     *
     * @return float|null
     */
    public function calculatePrice()
    {
        $this->total = parent::calculateRealPrice($this->precioRango, $this->nReferidos, $this->cuenta, $this->cuponDescuento);
        foreach ($this->getObjetosExtras() as $objetoExtra)
        {
            $this->total+= $objetoExtra->getPrecio();
        }

        return true;
    }

    public function getPedidoBotsState()
    {
        if ($this->pedidoBots->count() > 0) {
            $esperando = $finalizado = $corriendo = 0;
            foreach ($this->pedidoBots as $bot) {
                if ($bot->getLvl() == 10)
                    $finalizado++; elseif ($bot->getLvl() != 0) {
                    $corriendo++;
                }
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


    /**
     * Set nReferidos
     *
     * @param integer $nReferidos
     * @return Pedido
     */
    public function setNReferidos($nReferidos)
    {
        $this->nReferidos = $nReferidos;

        return $this;
    }

    /**
     * Get nReferidos
     *
     * @return integer
     */
    public function getNReferidos()
    {
        return $this->nReferidos;
    }

    /**
     * Set precioRango
     *
     * @param \MGD\BasicBundle\Entity\PrecioRango $precioRango
     * @return Pedido
     */
    public function setPrecioRango(\MGD\BasicBundle\Entity\PrecioRango $precioRango = null)
    {
        $this->precioRango = $precioRango;

        return $this;
    }

    /**
     * Get precioRango
     *
     * @return \MGD\BasicBundle\Entity\PrecioRango
     */
    public function getPrecioRango()
    {
        return $this->precioRango;
    }

    /**
     * @param \MGD\BasicBundle\Entity\PedidoOpinion $opinion
     */
    public function setOpinion($opinion)
    {
        $this->opinion = $opinion;
    }

    /**
     * @return \MGD\BasicBundle\Entity\PedidoOpinion
     */
    public function getOpinion()
    {
        return $this->opinion;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param $queueRemainingDays
     * @return Pedido
     */
    public function setQueueRemainingDays($queueRemainingDays)
    {
        $this->queueRemainingDays = $queueRemainingDays;

        return $this;
    }

    /**
     * @return int
     */
    public function getQueueRemainingDays()
    {
        return $this->queueRemainingDays;
    }

    /**
     * @return Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     * @return $this
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
        return $this;
    }




    /**
     * Add objetosExtras
     *
     * @param \MGD\BasicBundle\Entity\ObjetoExtra $objetosExtras
     * @return Pedido
     */
    public function addObjetosExtra(\MGD\BasicBundle\Entity\ObjetoExtra $objetosExtras)
    {
        $this->objetosExtras[] = $objetosExtras;
    
        return $this;
    }

    /**
     * Remove objetosExtras
     *
     * @param \MGD\BasicBundle\Entity\ObjetoExtra $objetosExtras
     */
    public function removeObjetosExtra(\MGD\BasicBundle\Entity\ObjetoExtra $objetosExtras)
    {
        $this->objetosExtras->removeElement($objetosExtras);
    }

    /**
     * Get objetosExtras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetosExtras()
    {
        return $this->objetosExtras;
    }
}