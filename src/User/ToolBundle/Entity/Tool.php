<?php

namespace User\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tool
 *
 * @ORM\Table(name="tool")
 * @ORM\Entity(repositoryClass="User\ToolBundle\Repository\ToolRepository")
 */
class Tool
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
     * @ORM\Column(name="codenum", type="string", length=32, unique=true)
     */
    private $codenum;

    /**
     * @var array
     *
     * @ORM\Column(name="cplist", type="json_array", nullable=true)
     */
    private $cplist;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=18)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="type", type="json_array")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="kword", type="string", length=255)
     */
    private $kword;

    /**
     * @var string
     *
     * @ORM\Column(name="dword", type="string", length=255)
     */
    private $dword;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=32)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    /**
     * @var bool
     *
     * @ORM\Column(name="recommend", type="boolean")
     */
    private $recommend;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="Toolsite", mappedBy="tools")
     */
    private $toolsite;

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
     * Set codenum
     *
     * @param string $codenum
     *
     * @return Tool
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
     * Set cplist
     *
     * @param array $cplist
     *
     * @return Tool
     */
    public function setCplist($cplist)
    {
        $this->cplist = $cplist;

        return $this;
    }

    /**
     * Get cplist
     *
     * @return array
     */
    public function getCplist()
    {
        return $this->cplist;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tool
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
     * Set kword
     *
     * @param string $kword
     *
     * @return Tool
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
     * Set dword
     *
     * @param string $dword
     *
     * @return Tool
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
     * Set content
     *
     * @param string $content
     *
     * @return Tool
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Tool
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Tool
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
     * Set recommend
     *
     * @param boolean $recommend
     *
     * @return Tool
     */
    public function setRecommend($recommend)
    {
        $this->recommend = $recommend;

        return $this;
    }

    /**
     * Get recommend
     *
     * @return bool
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Tool
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
     * Set type
     *
     * @param array $type
     *
     * @return Tool
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
     * Constructor
     */
    public function __construct()
    {
        $this->toolsite = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add toolsite
     *
     * @param \User\ToolBundle\Entity\Toolsite $toolsite
     *
     * @return Tool
     */
    public function addToolsite(\User\ToolBundle\Entity\Toolsite $toolsite)
    {
        $this->toolsite[] = $toolsite;

        return $this;
    }

    /**
     * Remove toolsite
     *
     * @param \User\ToolBundle\Entity\Toolsite $toolsite
     */
    public function removeToolsite(\User\ToolBundle\Entity\Toolsite $toolsite)
    {
        $this->toolsite->removeElement($toolsite);
    }

    /**
     * Get toolsite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToolsite()
    {
        return $this->toolsite;
    }
}
