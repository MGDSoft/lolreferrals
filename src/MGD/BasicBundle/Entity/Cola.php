<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cola
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cola
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
     * @var integer
     *
     * @ORM\Column(name="referals_per_day", nullable=true, type="integer")
     */
    private $referalsPerDay;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * dynamically generated AllQueueReferralsRemaining / referralsPerDay
     *
     * @var int
     */
    private $queueRemainingDays;


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
     * Set text
     *
     * @param string $text
     * @return Cola
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param int $referalsPerDay
     */
    public function setReferalsPerDay($referalsPerDay)
    {
        $this->referalsPerDay = $referalsPerDay;
    }

    /**
     * @return int
     */
    public function getReferalsPerDay()
    {
        return $this->referalsPerDay;
    }

    /**
     * @param int $queueRemainingDays
     */
    public function setQueueRemainingDays($queueRemainingDays)
    {
        $this->queueRemainingDays = $queueRemainingDays;
    }

    /**
     * @return int
     */
    public function getQueueRemainingDays()
    {
        return $this->queueRemainingDays;
    }


}