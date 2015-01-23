<?php

namespace Ebus\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 * 
 * @JMS\ExclusionPolicy("all")
 */
class Category {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;
    
    /**
     * @ORM\OneToMany(targetEntity="Furniture", mappedBy="category")
     **/
    protected $furnitures;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->furnitures = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("name")
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Category
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
     * Add furnitures
     *
     * @param \Ebus\MyBundle\Entity\Furniture $furnitures
     * @return Category
     */
    public function addFurniture(\Ebus\MyBundle\Entity\Furniture $furnitures)
    {
        $this->furnitures[] = $furnitures;

        return $this;
    }

    /**
     * Remove furnitures
     *
     * @param \Ebus\MyBundle\Entity\Furniture $furnitures
     */
    public function removeFurniture(\Ebus\MyBundle\Entity\Furniture $furnitures)
    {
        $this->furnitures->removeElement($furnitures);
    }

    /**
     * Get furnitures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFurnitures()
    {
        return $this->furnitures;
    }
    
    public function __toString() {
        return $this->getName();
    }
}
