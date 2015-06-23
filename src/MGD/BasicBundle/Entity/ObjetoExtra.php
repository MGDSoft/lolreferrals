<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Cuenta
 *
 * @ORM\Table(name="objeto_extra")
 * @ORM\Entity()
 */
class ObjetoExtra
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
     * @ORM\Column(name="nombre", type="string", length=200)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="float")
     * @Assert\NotBlank()
     */
    private $precio;

    public function __toString()
    {
        return $this->nombre.' '.$this->precio.'€';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this->nombre;
    }

    /**
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param string $precio
     * @return string $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
        return $this->precio;
    }




}