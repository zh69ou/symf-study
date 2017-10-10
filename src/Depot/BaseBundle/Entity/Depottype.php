<?php

namespace Depot\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depottype
 *
 * @ORM\Table(name="depottype")
 * @ORM\Entity(repositoryClass="Depot\BaseBundle\Repository\DepottypeRepository")
 */
class Depottype
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
     * @var int
     *
     * @ORM\Column(name="pid", type="integer")
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=18)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=18)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="dword", type="string", length=255, nullable=true)
     */
    private $dword;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint", nullable=true)
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
     * Set site
     *
     * @param string $site
     *
     * @return Depot
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
     * Set pid
     *
     * @param integer $pid
     *
     * @return Depottype
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Depottype
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
     * Set dword
     *
     * @param string $dword
     *
     * @return Depottype
     */
    public function setDword($dword)
    {
        $this->dword = $dword;

        return $this;
    }

    /**
     * Get dword
     *
     * @return string
     */
    public function getDword()
    {
        return $this->dword;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Depottype
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Depottype
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
