<?php

namespace User\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Toolsite
 *
 * @ORM\Table(name="toolsite")
 * @ORM\Entity(repositoryClass="User\ToolBundle\Repository\ToolsiteRepository")
 */
class Toolsite
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
     */
    private $tool;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=18)
     */
    private $site;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="btime", type="date")
     */
    private $btime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="etime", type="date")
     */
    private $etime;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="Tool", inversedBy="toolsite")
     * @ORM\JoinColumn(name="tool", referencedColumnName="codenum")
     */
    private $tools;


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
     * @return Toolsite
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
     * @return Toolsite
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
     * Set btime
     *
     * @param \DateTime $btime
     *
     * @return Toolsite
     */
    public function setBtime($btime)
    {
        $this->btime = $btime;

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
     * @return Toolsite
     */
    public function setEtime($etime)
    {
        $this->etime = $etime;

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
     * Set state
     *
     * @param integer $state
     *
     * @return Toolsite
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
     * Set tools
     *
     * @param \User\ToolBundle\Entity\Tool $tools
     *
     * @return Toolsite
     */
    public function setTools(\User\ToolBundle\Entity\Tool $tools = null)
    {
        $this->tools = $tools;

        return $this;
    }

    /**
     * Get tools
     *
     * @return \User\ToolBundle\Entity\Tool
     */
    public function getTools()
    {
        return $this->tools;
    }

}
