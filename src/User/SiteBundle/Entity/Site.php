<?php

namespace User\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="User\SiteBundle\Repository\SiteRepository")
 */
class Site
{
    const NUM_ITEMS = 10;
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
     * @ORM\Column(name="name", type="string", length=18, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="uid", type="integer")
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="kword", type="string", length=255)
     */
    private $kword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endtime", type="datetime")
     */
    private $endtime;

    /**
     * @var array
     *
     * @ORM\Column(name="setcon", type="array")
     */
    private $setcon;

    /**
     * @var array
     *
     * @ORM\Column(name="menuls", type="array")
     */
    private $menuls;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;


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
     * Set name
     *
     * @param string $name
     *
     * @return Site
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
     * Set uid
     *
     * @param integer $uid
     *
     * @return Site
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Site
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set kword
     *
     * @param string $kword
     *
     * @return Site
     */
    public function setKword($kword)
    {
        $this->kword = $kword;

        return $this;
    }

    /**
     * Get kword
     *
     * @return string
     */
    public function getKword()
    {
        return $this->kword;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     *
     * @return Site
     */
    public function setEndtime($endtime)
    {
        $this->endtime = new \DateTime($endtime);
        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

     /**
     * Set setcon
     *
     * @param array $setcon
     *
     * @return Site
     */
    public function setSetcon($setcon)
    {
        $this->setcon = $setcon;

        return $this;
    }

    /**
     * Get setcon
     *
     * @return array
     */
    public function getSetcon()
    {
        return $this->setcon;
    }

     /**
     * Set menuls
     *
     * @param array $menuls
     *
     * @return Menuls
     */
    public function setMenuls($menuls)
    {
        $this->menuls = $menuls;

        return $this;
    }

    /**
     * Get menuls
     *
     * @return array
     */
    public function getMenuls()
    {
        return $this->menuls;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Site
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

}
