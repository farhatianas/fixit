<?php
namespace TagBundle\Concern;

trait Taggable {

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="TagBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;


    public function addTag(\TagBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \TagBundle\Entity\Tag $tag
     */
    public function removeTag(\TagBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}