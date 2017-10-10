<?php

namespace User\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fodder
 *
 * @ORM\Table(name="fodder")
 * @ORM\Entity(repositoryClass="User\SiteBundle\Repository\FodderRepository")
 */
class Fodder
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
     * @Assert\Regex("/^[a-z0-9]+$/i", message="site.string")
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=18)
     * @Assert\Choice(choices = {"img", "file"})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\File(
     *     maxSize = "500k",
     *     mimeTypes = {"application/pdf", "application/x-pdf", "image/png", "image/jpg", "image/jpeg", "image/gif"},
     *     mimeTypesMessage = "fodder.file"
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=18)
     */
    private $size;

    /**
     * @var int
     *
     * @ORM\Column(name="uid", type="integer")
     */
    private $uid;

    /**
     * @var array
     *
     * @ORM\Column(name="otcon", type="array")
     * @Assert\All({
     *     @Assert\Regex("/^[a-z0-9]+$/i", message="otcon.string")
     * })
     */
    private $otcon;

    /**
     * @var bool
     *
     * @ORM\Column(name="share", type="boolean")
     */
    private $share;

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
     * Set site
     *
     * @param string $site
     *
     * @return Fodder
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
     * Set type
     *
     * @param string $type
     *
     * @return Fodder
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Fodder
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
     * Set size
     *
     * @param string $size
     *
     * @return Fodder
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     *
     * @return Fodder
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
     * Set otcon
     *
     * @param array $otcon
     *
     * @return Fodder
     */
    public function setOtcon($otcon)
    {
        $this->otcon = $otcon;

        return $this;
    }

    /**
     * Get otcon
     *
     * @return array
     */
    public function getOtcon()
    {
        return $this->otcon;
    }

    /**
     * Set share
     *
     * @param boolean $share
     *
     * @return Fodder
     */
    public function setShare($share)
    {
        $this->share = $share;

        return $this;
    }

    /**
     * Get share
     *
     * @return bool
     */
    public function getShare()
    {
        return $this->share;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Fodder
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
