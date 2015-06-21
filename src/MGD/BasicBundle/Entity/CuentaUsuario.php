<?php

namespace MGD\BasicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta_usuario")
 * @ORM\Entity()
 */
class CuentaUsuario
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
     * @ORM\Column(name="usuario", type="string", length=200)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=200)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usado", type="boolean", nullable=true)
     */
    private $usado=false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     * @return string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this->usuario;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this->password;
    }

    /**
     * @return boolean
     */
    public function isUsado()
    {
        return $this->usado;
    }

    /**
     * @param boolean $usado
     * @return $this
     */
    public function setUsado($usado)
    {
        $this->usado = $usado;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}