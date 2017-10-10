<?php

namespace Depot\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depotstate
 *
 * @ORM\Table(name="depotstate")
 * @ORM\Entity(repositoryClass="Depot\BaseBundle\Repository\DepotstateRepository")
 */
class Depotstate
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
     * @ORM\Column(name="deid", type="integer")
     */
    private $deid;

    /**
     * @var int
     *
     * @ORM\Column(name="num", type="integer")
     */
    private $num;

    /**
     * @var string
     *
     * @ORM\Column(name="baseprice", type="string", length=18, nullable=true)
     */
    private $baseprice;

    /**
     * @var string
     *
     * @ORM\Column(name="sellprice", type="string", length=18, nullable=true)
     */
    private $sellprice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="itime", type="datetime")
     */
    private $itime;

    /**
     * @var string
     *
     * @ORM\Column(name="backups", type="text", nullable=true)
     */
    private $backups;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="Depot", inversedBy="depotstate")
     * @ORM\JoinColumn(name="deid", referencedColumnName="id")
     */
    private $depot;


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
     * Set deid
     *
     * @param integer $deid
     *
     * @return Depotstate
     */
    public function setDeid($deid)
    {
        $this->deid = $deid;

        return $this;
    }

    /**
     * Get deid
     *
     * @return int
     */
    public function getDeid()
    {
        return $this->deid;
    }

    /**
     * Set itime
     *
     * @param \DateTime $itime
     *
     * @return Depotstate
     */
    public function setItime()
    {
        $this->itime = new \DateTime();

        return $this;
    }

    /**
     * Get itime
     *
     * @return \DateTime
     */
    public function getItime()
    {
        return $this->itime;
    }

    /**
     * Set backups
     *
     * @param string $backups
     *
     * @return Depotstate
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
     * @return Depotstate
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
     * Set baseprice
     *
     * @param string $baseprice
     *
     * @return Depotstate
     */
    public function setBaseprice($baseprice)
    {
        $this->baseprice = $baseprice;

        return $this;
    }

    /**
     * Get baseprice
     *
     * @return string
     */
    public function getBaseprice()
    {
        return $this->baseprice;
    }

    /**
     * Set sellprice
     *
     * @param string $sellprice
     *
     * @return Depotstate
     */
    public function setSellprice($sellprice)
    {
        $this->sellprice = $sellprice;

        return $this;
    }

    /**
     * Get sellprice
     *
     * @return string
     */
    public function getSellprice()
    {
        return $this->sellprice;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Depotstate
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set depot
     *
     * @param \Depot\BaseBundle\Entity\Depot $depot
     *
     * @return Depotstate
     */
    public function setDepot(\Depot\BaseBundle\Entity\Depot $depot = null)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \Depot\BaseBundle\Entity\Depot
     */
    public function getDepot()
    {
        return $this->depot;
    }
}
