<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Noticia
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Noticia
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
	 * @ORM\ManyToOne(targetEntity="\MGD\FrameworkBundle\Entity\Usuario", fetch="EAGER")
	 * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
	 */
	private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="noticia", type="text")
     * @Assert\NotBlank()
     */
    private $noticia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"titulo"},style="camel",  updatable=false, unique=true)
     */
    private $slug;


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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Noticia
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set noticia
     *
     * @param string $noticia
     *
     * @return Noticia
     */
    public function setNoticia($noticia)
    {
        $this->noticia = $noticia;
    
        return $this;
    }

    /**
     * Get noticia
     *
     * @return string 
     */
    public function getNoticia()
    {
        return $this->noticia;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Noticia
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Noticia
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }



    /**
     * Set usuario
     *
     * @param \MGD\FrameworkBundle\Entity\Usuario $usuario
     * @return Noticia
     */
    public function setUsuario(\MGD\FrameworkBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \MGD\FrameworkBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}