<?php

namespace MGD\BasicBundle\Entity\EXT;

use Doctrine\ORM\Mapping as ORM;
use MGD\BasicBundle\Entity\PedidoBots;

/**
 * EXTRefseo
 *
 * @ORM\Table(name="REFSEU")
 * @ORM\Entity
 */
class EXTRefseu
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="idREFSEU", type="integer")
     */
    private $idREFSEU;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="Username", type="string", length=20)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=20, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MGD\BasicBundle\Entity\Pedido", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="REFID", referencedColumnName="id", nullable=false)
     */
    private $rEFID;

    /**
     * @var integer
     *
     * @ORM\Column(name="Progress", type="smallint", nullable=true)
     */
    private $progress=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="Finished", type="smallint", nullable=true)
     */
    private $finished=0;

    /**
     * @var string
     *
     * @ORM\Column(name="BOTID", type="string", length=45)
     */
    private $bOTID='';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \String
     *
     * @ORM\Column(name="DateStarted", type="string", length=45, nullable=true)
     */
    private $dateStarted;

    /**
     * @var \String
     *
     * @ORM\Column(name="DateFinished", type="string", length=45, nullable=true)
     */
    private $dateFinished;

    function __construct(PedidoBots $bot)
    {
        $this->dateCreated = new \DateTime();
        $this->idREFSEU = $this->dateCreated->getTimestamp() + $bot->getId();
        $this->username = $bot->getNombre();
        $this->password = $bot->getContrasena();
        $this->rEFID = $bot->getPedido();
        //$this->bOTID = $bot->getId();
    }

    /**
     * Set idREFSEU
     *
     * @param integer $idREFSEU
     * @return EXTRefseo
     */
    public function setIdREFSEU($idREFSEU)
    {
        $this->idREFSEU = $idREFSEU;
    
        return $this;
    }

    /**
     * Get idREFSEU
     *
     * @return integer 
     */
    public function getIdREFSEU()
    {
        return $this->idREFSEU;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return EXTRefseo
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return EXTRefseo
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set rEFID
     *
     * @param string $rEFID
     * @return EXTRefseo
     */
    public function setREFID($rEFID)
    {
        $this->rEFID = $rEFID;
    
        return $this;
    }

    /**
     * Get rEFID
     *
     * @return string 
     */
    public function getREFID()
    {
        return $this->rEFID;
    }

    /**
     * Set progress
     *
     * @param integer $progress
     * @return EXTRefseo
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    
        return $this;
    }

    /**
     * Get progress
     *
     * @return integer 
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set finished
     *
     * @param integer $finished
     * @return EXTRefseo
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;
    
        return $this;
    }

    /**
     * Get finished
     *
     * @return integer 
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set bOTID
     *
     * @param string $bOTID
     * @return EXTRefseo
     */
    public function setBOTID($bOTID)
    {
        $this->bOTID = $bOTID;
    
        return $this;
    }

    /**
     * Get bOTID
     *
     * @return string 
     */
    public function getBOTID()
    {
        return $this->bOTID;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return EXTRefseo
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateStarted
     *
     * @param \DateTime $dateStarted
     * @return EXTRefseo
     */
    public function setDateStarted($dateStarted)
    {
        $this->dateStarted = $dateStarted;
    
        return $this;
    }

    /**
     * Get dateStarted
     *
     * @return \DateTime 
     */
    public function getDateStarted()
    {
        return $this->dateStarted;
    }

    /**
     * Set dateFinished
     *
     * @param \DateTime $dateFinished
     * @return EXTRefseo
     */
    public function setDateFinished($dateFinished)
    {
        $this->dateFinished = $dateFinished;
    
        return $this;
    }

    /**
     * Get dateFinished
     *
     * @return \DateTime 
     */
    public function getDateFinished()
    {
        return $this->dateFinished;
    }
}
