<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 *
 * @ORM\Table(name="topics", indexes={@ORM\Index(name="topics_ibfk_1", columns={"user_id"}), @ORM\Index(name="topics_ibfk_2", columns={"forum_id"})})
 * @ORM\Entity
 */
class Topic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_date", type="datetime", nullable=false)
     */
    private $addedDate;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Forum
     *
     * @ORM\ManyToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forum_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $forum;

    /**
     * @var boolean
     * @ORM\Column(name="closed", type="boolean", options={"default":false})
     */
    private $closed;

    /**
     * @var boolean
     * @ORM\Column(name="pinned", type="boolean", options={"default":false})
     */
    private $pinned;

    /**
     * @var string
     */
    private $postContent;

    /**
     * Set postContent
     *
     * @param string $postContent
     *
     * @return Topic
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;

        return $this;
    }

    /**
     * Get postContent
     *
     * @return string
     */
    public function getPostContent()
    {
        return $this->postContent;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addedDate = new \DateTime();
        $this->closed = false;
        $this->pinned = false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Topic
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
     * Set addedDate
     *
     * @param \DateTime $addedDate
     *
     * @return Topic
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     *
     * @return Topic
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set pinned
     *
     * @param boolean $pinned
     *
     * @return Topic
     */
    public function setPinned($pinned)
    {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get pinned
     *
     * @return boolean
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Topic
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set forum
     *
     * @param \ForumBundle\Entity\Forum $forum
     *
     * @return Topic
     */
    public function setForum(\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }
}
