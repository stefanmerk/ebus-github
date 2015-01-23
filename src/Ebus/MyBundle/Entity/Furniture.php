<?php

namespace Ebus\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="furniture")
 * @ORM\HasLifecycleCallbacks
 * 
 * @JMS\ExclusionPolicy("all")
 */
class Furniture {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 0.01,
     *      max = 9999,
     *      minMessage = "Ihr Preis muss mindestens {{ limit }}€/Tag betragen",
     *      maxMessage = "Ihr Preis darf maximal {{ limit }}€/Tag sein"
     * )
     */
    protected $price;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="furnitures", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\NotBlank()
     **/
    protected $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="furnitures", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;
    
     /**
     * @ORM\ManyToOne(targetEntity="Condition", inversedBy="furnitures", fetch="EAGER")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id")
     * @Assert\NotBlank()
     **/
    protected $condition;
    
    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="furniture")
     **/
    protected $ratings;
    
    /**
     * @ORM\OneToMany(targetEntity="Borrow", mappedBy="furniture")
     **/
    protected $borrows;
    
    /**
     * @Assert\File(maxSize="6000000")
     * @Assert\Image()
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image
            ? null
            : '/'.$this->getUploadDir().'/'.$this->image;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/furniture';
    }
        
    public function upload(){
    // the file property can be empty if the field is not required
    if (null === $this->getFile()) {
        return;
    }
        
    // use the original file name here but you should
    // sanitize it at least to avoid any security issues
        
    $newFileName = uniqid().md5(mt_rand(0, 99999)) . '.' . $this->getFile()->getClientOriginalExtension();
    
    // move takes the target directory and then the
    // target filename to move to
    $this->getFile()->move(
        $this->getUploadRootDir(),
        $newFileName
    );
        
    // set the path property to the filename where you've saved the file
    $this->image = $newFileName;
        
    // clean up the file property as you won't need it anymore
    $this->file = null;
}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    /**
     * Get id
     *
     * @return integer 
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
     * @return Furniture
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
     * @JMS\VirtualProperty
     * @JMS\SerializedName("name")
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Furniture
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("description")
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Furniture
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Furniture
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
     * @JMS\VirtualProperty
     * @JMS\SerializedName("price")
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Furniture
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
     * Set category
     *
     * @param \Ebus\MyBundle\Entity\Category $category
     * @return Furniture
     */
    public function setCategory(\Ebus\MyBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Ebus\MyBundle\Entity\Category 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("category")
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \Ebus\MyBundle\Entity\User $user
     * @return Furniture
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
     * Set condition
     *
     * @param \Ebus\MyBundle\Entity\Condition $condition
     * @return Furniture
     */
    public function setCondition(\Ebus\MyBundle\Entity\Condition $condition = null)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition
     *
     * @return \Ebus\MyBundle\Entity\Condition 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("condition")
     */
    public function getCondition()
    {
        return $this->condition;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ratings
     *
     * @param \Ebus\MyBundle\Entity\Rating $ratings
     * @return Furniture
     */
    public function addRating(\Ebus\MyBundle\Entity\Rating $ratings)
    {
        $this->ratings[] = $ratings;

        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \Ebus\MyBundle\Entity\Rating $ratings
     */
    public function removeRating(\Ebus\MyBundle\Entity\Rating $ratings)
    {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("ratings")
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add borrows
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrows
     * @return Furniture
     */
    public function addBorrow(\Ebus\MyBundle\Entity\Borrow $borrows)
    {
        $this->borrows[] = $borrows;

        return $this;
    }

    /**
     * Remove borrows
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrows
     */
    public function removeBorrow(\Ebus\MyBundle\Entity\Borrow $borrows)
    {
        $this->borrows->removeElement($borrows);
    }

    /**
     * Get borrows
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBorrows()
    {
        return $this->borrows;
    }
    
    public function __toString() {
        return $this->getName();
    }
}
