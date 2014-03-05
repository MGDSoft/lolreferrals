<?php

namespace MGD\BasicBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BotCuenta
 *
 * @ORM\Table(name="pedido_bots")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PedidoBotsRepository")
 */
class PedidoBots
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", unique=true, length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasena", type="string", length=255)
     */
    private $contrasena;

    /**
     * @var integer
     *
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl=0;

    /**
     * @var Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidoBots")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    private $pedido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime")
     * @Gedmo\Timestampable(on="change", field={"lvl"})
     */
    private $updateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $creadoDate;


    function __construct()
    {
        $this->updateDate = new DateTime();
    }

    /**
     * @param \MGD\BasicBundle\Entity\Pedido $pedido
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * @return \MGD\BasicBundle\Entity\Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
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
     * Set nombre
     *
     * @param string $nombre
     * @return BotCuenta
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set contrasena
     *
     * @param string $contrasena
     * @return BotCuenta
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    
        return $this;
    }

    /**
     * Get contrasena
     *
     * @return string 
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * Set creadoDate
     *
     * @param string $creadoDate
     * @return BotCuenta
     */
    public function setCreadoDate($creadoDate)
    {
        $this->creadoDate = $creadoDate;
    
        return $this;
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

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return BotCuenta
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    
        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return BotCuenta
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }
}