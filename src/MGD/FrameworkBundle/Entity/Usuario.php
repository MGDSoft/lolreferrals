<?php

namespace MGD\FrameworkBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="\MGD\FrameworkBundle\Entity\Rol")
     * @ORM\JoinTable(name="usuario_roles",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $user_roles;

    public function __construct()
    {
        $this->user_roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add user_roles
     *
     * @param \MGD\FrameworkBundle\Entity\Rol $userRoles
     */
    public function addRol(\MGD\FrameworkBundle\Entity\Rol $userRoles)
    {
        $this->user_roles[] = $userRoles;
    }

    public function setUserRoles($roles) {
        $this->user_roles = $roles;
    }

    /**
     * Get user_roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->user_roles as $role) {
            $roles[] = $role->getRole();
        }

        return $roles;
    }

    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user) {
        return md5($this->getUsername()) == md5($user->getUsername());

    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials() {

    }

    /**
     * Add user_roles
     *
     * @param \MGD\FrameworkBundle\Entity\Rol $userRoles
     * @return Usuario
     */
    public function addUserRole(Rol $userRoles)
    {
        $this->user_roles[] = $userRoles;

        return $this;
    }

    /**
     * Remove user_roles
     *
     * @param \MGD\FrameworkBundle\Entity\Rol $userRoles
     */
    public function removeUserRole(Rol $userRoles)
    {
        $this->user_roles->removeElement($userRoles);
    }

	public function __toString()
	{
		return $this->username;
	}

}
