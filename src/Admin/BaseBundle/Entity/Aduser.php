<?php

namespace Admin\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Aduser
 *
 * @ORM\Table(name="aduser")
 * @ORM\Entity(repositoryClass="Admin\BaseBundle\Repository\AduserRepository")
 */
class Aduser implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=18, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=32, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="himg", type="string", length=255)
     */
    private $himg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="regtime", type="datetime")
     */
    private $regtime;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Aduser
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
     * Set email
     *
     * @param string $email
     *
     * @return Aduser
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Aduser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Aduser
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
     * Set himg
     *
     * @param string $himg
     *
     * @return Aduser
     */
    public function setHimg($himg)
    {
        $this->himg = $himg;

        return $this;
    }

    /**
     * Get himg
     *
     * @return string
     */
    public function getHimg()
    {
        return $this->himg;
    }

    /**
     * Set regtime
     *
     * @param \DateTime $regtime
     *
     * @return Aduser
     */
    public function setRegtime()
    {
        $this->regtime = new \DateTime();
        return $this;
    }

    /**
     * Get regtime
     *
     * @return \DateTime
     */
    public function getRegtime()
    {
        return $this->regtime;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Aduser
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Aduser
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = '';
        }

        return array_unique($roles);
    }

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}

