<?php

namespace User\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Siteuser
 *
 * @ORM\Table(name="siteuser")
 * @ORM\Entity(repositoryClass="User\SiteBundle\Repository\SiteuserRepository")
 */
class Siteuser
{
    const NUM_ITEMS = 10;
    // const CONT_TYPE = array('mobile'=>'手机','addr'=>'地址');
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
     * @Assert\Regex("/^[a-z0-9]+$/i", message="user.string")
     * @Assert\Length(min=3, max=18, minMessage="user.length.min", maxMessage="user.length.max")
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
     * @var array
     *
     * @ORM\Column(name="post", type="array")
     * @Assert\All({
     *     @Assert\Regex("/^[a-z0-9\x80-\xff]+$/i", message="content.string")
     * })
     */
    private $post;

    /**
     * @var array
     *
     * @ORM\Column(name="content", type="array")
     * @Assert\All({
     *     @Assert\Regex("/^[a-z0-9_\.@\-\x80-\xff]+$/i", message="content.string")
     * })
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     * @Assert\Regex("/^[0-9]+$/i", message="user.sort")
     */
    private $sort;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\Choice(choices = {"0", "1", "2"})
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="\User\BaseBundle\Entity\User", inversedBy="siteuser")
     * @ORM\JoinColumn(name="uid", referencedColumnName="id")
     */
    private $user;


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
     * @return Siteuser
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
     * @return Siteuser
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
     * Set post
     *
     * @param array $post
     *
     * @return Siteuser
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set content
     *
     * @param array $content
     *
     * @return Siteuser
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Siteuser
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
     * @return Siteuser
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
     * Set user
     *
     * @param \User\BaseBundle\Entity\User $user
     *
     * @return Siteuser
     */
    public function setUser(\User\BaseBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\BaseBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
