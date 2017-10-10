<?php

namespace User\ToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tooltype
 *
 * @ORM\Table(name="tooltype")
 * @ORM\Entity(repositoryClass="User\ToolBundle\Repository\TooltypeRepository")
 */
class Tooltype
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
     * @var int
     *
     * @ORM\Column(name="pid", type="integer")
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=18)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="dword", type="string", length=255)
     */
    private $dword;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

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
     * Set pid
     *
     * @param integer $pid
     *
     * @return Tooltype
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
     * @return Tooltype
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
     * @return Tooltype
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
     * @return Tooltype
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
     * @return Tooltype
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
