<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Estado
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Estado
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_admin", type="string", length=255, nullable=true)
     */
    private $descripcionAdmin;

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
     *
     * @return Estado
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
     * Set descripcionAdmin
     *
     * @param string $descripcionAdmin
     *
     * @return Estado
     */
    public function setDescripcionAdmin($descripcionAdmin)
    {
        $this->descripcionAdmin = $descripcionAdmin;
    
        return $this;
    }

    /**
     * Get descripcionAdmin
     *
     * @return string 
     */
    public function getDescripcionAdmin()
    {
        return $this->descripcionAdmin;
    }

	public function __toString(){
		return $this->nombre;
	}
}