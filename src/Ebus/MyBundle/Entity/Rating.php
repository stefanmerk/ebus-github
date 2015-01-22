<?php

namespace Ebus\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="rating")
 * 
 * @JMS\ExclusionPolicy("all")
 */
class Rating {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $stars;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $comment;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="furnitures", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Furniture", inversedBy="ratings")
     * @ORM\JoinColumn(name="furniture_id", referencedColumnName="id")
     **/
    protected $furniture;

    /**
     * Get id
     *
     * @return integer
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("id") 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set stars
     *
     * @param integer $stars
     * @return Rating
     */
    public function setStars($stars)
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return integer 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("stars")
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Rating
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("comment")
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Rating
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \Ebus\MyBundle\Entity\User $user
     * @return Rating
     */
    public function setUser(\Ebus\MyBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ebus\MyBundle\Entity\User 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("user")
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set furniture
     *
     * @param \Ebus\MyBundle\Entity\Furniture $furniture
     * @return Rating
     */
    public function setFurniture(\Ebus\MyBundle\Entity\Furniture $furniture = null)
    {
        $this->furniture = $furniture;

        return $this;
    }

    /**
     * Get furniture
     *
     * @return \Ebus\MyBundle\Entity\Furniture 
     */
    public function getFurniture()
    {
        return $this->furniture;
    }
}
