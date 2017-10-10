<?php

namespace User\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sitepost
 *
 * @ORM\Table(name="sitepost")
 * @ORM\Entity(repositoryClass="User\SiteBundle\Repository\SitepostRepository")
 */
class Sitepost
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
     * @Assert\Regex("/^[a-z0-9]+$/i", message="post.string")
     * @Assert\Length(min=3, max=18, minMessage="post.length.min", maxMessage="post.length.max")
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\x80-\xff]+$/i", message="name.string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="pid", type="integer", nullable=true)
     * @Assert\Regex("/^[0-9]+$/i", message="pid.string")
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="makeup", type="string", length=255, nullable=true)
     * @Assert\Regex("/^[a-z0-9_\.\-]+$/i", message="content.string")
     */
    private $makeup;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     * @Assert\Regex("/^[0-9]+$/i", message="post.sort")
     */
    private $sort;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\Choice(choices = {"0", "1"})
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="Sitepost", inversedBy="tpost")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id")
     */
    private $cpost;

    /**
     * @ORM\OneToMany(targetEntity="Sitepost", mappedBy="cpost")
     */
    private $tpost;


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
     * @return Sitepost
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
     * @return Sitepost
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
     * Set pid
     *
     * @param integer $pid
     *
     * @return Sitepost
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
     * Set makeup
     *
     * @param string $makeup
     *
     * @return Sitepost
     */
    public function setMakeup($makeup)
    {
        $this->makeup = $makeup;

        return $this;
    }

    /**
     * Get makeup
     *
     * @return string
     */
    public function getMakeup()
    {
        return $this->makeup;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Sitepost
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
     * @return Sitepost
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
        $this->tpost = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cpost
     *
     * @param \User\SiteBundle\Entity\Sitepost $cpost
     *
     * @return Sitepost
     */
    public function setCpost(\User\SiteBundle\Entity\Sitepost $cpost = null)
    {
        $this->cpost = $cpost;

        return $this;
    }

    /**
     * Get cpost
     *
     * @return \User\SiteBundle\Entity\Sitepost
     */
    public function getCpost()
    {
        return $this->cpost;
    }

    /**
     * Add tpost
     *
     * @param \User\SiteBundle\Entity\Sitepost $tpost
     *
     * @return Sitepost
     */
    public function addTpost(\User\SiteBundle\Entity\Sitepost $tpost)
    {
        $this->tpost[] = $tpost;

        return $this;
    }

    /**
     * Remove tpost
     *
     * @param \User\SiteBundle\Entity\Sitepost $tpost
     */
    public function removeTpost(\User\SiteBundle\Entity\Sitepost $tpost)
    {
        $this->tpost->removeElement($tpost);
    }

    /**
     * Get tpost
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTpost()
    {
        return $this->tpost;
    }
}
