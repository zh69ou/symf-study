<?php

namespace Depot\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depot
 *
 * @ORM\Table(name="depot")
 * @ORM\Entity(repositoryClass="Depot\BaseBundle\Repository\DepotRepository")
 */
class Depot
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
     * @ORM\Column(name="site", type="string", length=18)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="codenum", type="string", length=128)
     */
    private $codenum;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="fodder", type="integer", nullable=true)
     */
    private $fodder;

    /**
     * @var array
     *
     * @ORM\Column(name="type", type="json_array", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gtime", type="date")
     */
    private $gtime;

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
     * @ORM\OneToMany(targetEntity="Depotstate", mappedBy="depot")
     */
    private $depotstate;

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
     * Set name
     *
     * @param string $name
     *
     * @return Depot
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
     * Set codenum
     *
     * @param string $codenum
     *
     * @return Depot
     */
    public function setCodenum($codenum)
    {
        $this->codenum = $codenum;

        return $this;
    }

    /**
     * Get codenum
     *
     * @return string
     */
    public function getCodenum()
    {
        return $this->codenum;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Depot
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set fodder
     *
     * @param integer $fodder
     *
     * @return Depot
     */
    public function setFodder($fodder)
    {
        $this->fodder = $fodder;

        return $this;
    }

    /**
     * Get fodder
     *
     * @return int
     */
    public function getFodder()
    {
        return $this->fodder;
    }

    /**
     * Set type
     *
     * @param array $type
     *
     * @return Depot
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set gtime
     *
     * @param \DateTime $gtime
     *
     * @return Depot
     */
    public function setGtime()
    {
        $this->gtime = new \DateTime();

        return $this;
    }

    /**
     * Get gtime
     *
     * @return \DateTime
     */
    public function getGtime()
    {
        return $this->gtime;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Depot
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
     * @return Depot
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
     * Constructor
     */
    public function __construct()
    {
        $this->depotstate = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add depotstate
     *
     * @param \Depot\BaseBundle\Entity\Depotstate $depotstate
     *
     * @return Depot
     */
    public function addDepotstate(\Depot\BaseBundle\Entity\Depotstate $depotstate)
    {
        $this->depotstate[] = $depotstate;

        return $this;
    }

    /**
     * Remove depotstate
     *
     * @param \Depot\BaseBundle\Entity\Depotstate $depotstate
     */
    public function removeDepotstate(\Depot\BaseBundle\Entity\Depotstate $depotstate)
    {
        $this->depotstate->removeElement($depotstate);
    }

    /**
     * Get depotstate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepotstate()
    {
        return $this->depotstate;
    }
}
