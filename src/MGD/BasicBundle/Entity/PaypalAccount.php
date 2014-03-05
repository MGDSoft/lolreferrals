<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PaypalAccount
 *
 * @ORM\Table(name="paypal_account")
 * @ORM\Entity(repositoryClass="MGD\BasicBundle\Entity\PaypalAccountRepository")
 */
class PaypalAccount
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
     * @ORM\Column(name="name", type="string", unique=true, length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="api_username", type="string", unique=true, length=255)
     */
    private $apiUsername;


    /**
     * @var string
     *
     * @ORM\Column(name="api_password", type="string", length=255)
     */
    private $apiPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="api_signature", type="string", length=255)
     */
    private $apiSignature;

    /**
     * @var float
     *
     * @ORM\Column(name="dinero_para_rotar", type="float")
     */
    private $dineroParaRotar;

    /**
     * @var float
     *
     * @ORM\Column(name="dinero_agregado", type="float")
     */
    private $dineroAgregado = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="dinero_agregado_total", type="float")
     */
    private $dineroAgregadoTotal = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_n", type="integer")
     */
    private $order;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active_boo", type="boolean", nullable=true)
     */
    private $active=false;


    public function __toString()
    {
        return $this->name;
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
     * Set apiUsername
     *
     * @param string $apiUsername
     * @return PaypalAccount
     */
    public function setApiUsername($apiUsername)
    {
        $this->apiUsername = $apiUsername;
    
        return $this;
    }

    /**
     * Get apiUsername
     *
     * @return string 
     */
    public function getApiUsername()
    {
        return $this->apiUsername;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return PaypalAccount
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set apiPassword
     *
     * @param string $apiPassword
     * @return PaypalAccount
     */
    public function setApiPassword($apiPassword)
    {
        $this->apiPassword = $apiPassword;
    
        return $this;
    }

    /**
     * Get apiPassword
     *
     * @return string 
     */
    public function getApiPassword()
    {
        return $this->apiPassword;
    }

    /**
     * Set apiSignature
     *
     * @param string $apiSignature
     * @return PaypalAccount
     */
    public function setApiSignature($apiSignature)
    {
        $this->apiSignature = $apiSignature;
    
        return $this;
    }

    /**
     * Get apiSignature
     *
     * @return string 
     */
    public function getApiSignature()
    {
        return $this->apiSignature;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return PaypalAccount
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }



    /**
     * Set dineroParaRotar
     *
     * @param float $dineroParaRotar
     * @return PaypalAccount
     */
    public function setDineroParaRotar($dineroParaRotar)
    {
        $this->dineroParaRotar = $dineroParaRotar;
    
        return $this;
    }

    /**
     * Get dineroParaRotar
     *
     * @return float 
     */
    public function getDineroParaRotar()
    {
        return $this->dineroParaRotar;
    }

    /**
     * Set dineroAgregado
     *
     * @param float $dineroAgregado
     * @return PaypalAccount
     */
    public function setDineroAgregado($dineroAgregado)
    {
        $this->dineroAgregado = $dineroAgregado;
    
        return $this;
    }

    /**
     * Set dineroAgregado
     *
     * @param float $dineroAgregado
     * @return PaypalAccount
     */
    public function sumDineroAgregado($dineroAgregado)
    {
        $this->dineroAgregado += $dineroAgregado;
        $this->dineroAgregadoTotal += $dineroAgregado;

        return $this;
    }

    /**
     * Get dineroAgregado
     *
     * @return float 
     */
    public function getDineroAgregado()
    {
        return $this->dineroAgregado;
    }

    /**
     * Set dineroAgregadoTotal
     *
     * @param float $dineroAgregadoTotal
     * @return PaypalAccount
     */
    public function setDineroAgregadoTotal($dineroAgregadoTotal)
    {
        $this->dineroAgregadoTotal = $dineroAgregadoTotal;
    
        return $this;
    }

    /**
     * Get dineroAgregadoTotal
     *
     * @return float 
     */
    public function getDineroAgregadoTotal()
    {
        return $this->dineroAgregadoTotal;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return PaypalAccount
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function getPorcentajeRestante()
    {
        if (! $this->active)
            return "";

        return round($this->dineroAgregado/$this->dineroParaRotar,4)*100;
    }
}