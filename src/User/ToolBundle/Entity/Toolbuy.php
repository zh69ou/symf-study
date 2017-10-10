<?php

namespace User\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Toolbuy
 *
 * @ORM\Table(name="toolbuy")
 * @ORM\Entity(repositoryClass="User\ToolBundle\Repository\ToolbuyRepository")
 */
class Toolbuy
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
     * @ORM\Column(name="tool", type="string", length=32)
     * @Assert\Regex("/^[a-z0-9]+$/i", message="tool.string")
     */
    private $tool;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=18)
     * @Assert\Regex("/^[a-z0-9]+$/i", message="tool.string")
     */
    private $site;

    /**
     * @var int
     *
     * @ORM\Column(name="uid", type="integer")
     * @Assert\Regex("/^[0-9]+$/i", message="uid.string")
     */
    private $uid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="btime", type="date")
     * @Assert\Date(message="tool.btime")
     */
    private $btime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="etime", type="date")
     * @Assert\Date(message="tool.etime")
     */
    private $etime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="atime", type="date")
     * @Assert\Date(message="tool.atime")
     */
    private $atime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ptime", type="date")
     * @Assert\Date(message="tool.ptime")
     */
    private $ptime;

    /**
     * @var string
     *
     * @ORM\Column(name="yprice", type="string", length=32)
     * @Assert\Regex("/^[a-z0-9]+$/i", message="tool.string")
     */
    private $yprice;

    /**
     * @var string
     *
     * @ORM\Column(name="sprice", type="string", length=32)
     * @Assert\Regex("/^[a-z0-9]+$/i", message="tool.string")
     */
    private $sprice;

    /**
     * @var string
     *
     * @ORM\Column(name="backups", type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\x80-\xff]+$/i", message="tool.backups")
     */
    private $backups;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\Choice(choices = {"0", "1", "2", "3"})
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
     * Set tool
     *
     * @param string $tool
     *
     * @return Toolbuy
     */
    public function setTool($tool)
    {
        $this->tool = $tool;

        return $this;
    }

    /**
     * Get tool
     *
     * @return string
     */
    public function getTool()
    {
        return $this->tool;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Toolbuy
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     *
     * @return Toolbuy
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
     * Set btime
     *
     * @param \DateTime $btime
     *
     * @return Toolbuy
     */
    public function setBtime($btime)
    {
        $this->btime = new \DateTime($btime);
        return $this;
    }

    /**
     * Get btime
     *
     * @return \DateTime
     */
    public function getBtime()
    {
        return $this->btime;
    }

    /**
     * Set etime
     *
     * @param \DateTime $etime
     *
     * @return Toolbuy
     */
    public function setEtime($etime)
    {
        $this->etime = new \DateTime($etime);

        return $this;
    }

    /**
     * Get etime
     *
     * @return \DateTime
     */
    public function getEtime()
    {
        return $this->etime;
    }

    /**
     * Set atime
     *
     * @param \DateTime $atime
     *
     * @return Toolbuy
     */
    public function setAtime()
    {
        $this->atime = new \DateTime();

        return $this;
    }

    /**
     * Get atime
     *
     * @return \DateTime
     */
    public function getAtime()
    {
        return $this->atime;
    }

    /**
     * Set ptime
     *
     * @param \DateTime $ptime
     *
     * @return Toolbuy
     */
    public function setPtime($ptime)
    {
        $this->ptime = new \DateTime($ptime);

        return $this;
    }

    /**
     * Get ptime
     *
     * @return \DateTime
     */
    public function getPtime()
    {
        return $this->ptime;
    }

    /**
     * Set yprice
     *
     * @param string $yprice
     *
     * @return Toolbuy
     */
    public function setYprice($yprice)
    {
        $this->yprice = $yprice;

        return $this;
    }

    /**
     * Get yprice
     *
     * @return string
     */
    public function getYprice()
    {
        return $this->yprice;
    }

    /**
     * Set sprice
     *
     * @param string $sprice
     *
     * @return Toolbuy
     */
    public function setSprice($sprice)
    {
        $this->sprice = $sprice;

        return $this;
    }

    /**
     * Get sprice
     *
     * @return string
     */
    public function getSprice()
    {
        return $this->sprice;
    }

    /**
     * Set backups
     *
     * @param string $backups
     *
     * @return Toolbuy
     */
    public function setBackups($backups)
    {
        $this->backups = $backups;

        return $this;
    }

    /**
     * Get backups
     *
     * @return string
     */
    public function getBackups()
    {
        return $this->backups;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Toolbuy
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
