<?php

namespace Ebus\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="authuser")
 * 
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $firstName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastName;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $street;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $streetNumber;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $zip;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $town;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $gps;
    
    /**
     * @ORM\OneToMany(targetEntity="Furniture", mappedBy="category")
     **/
    protected $furnitures;
    
    /**
     * @ORM\OneToMany(targetEntity="Borrow", mappedBy="leaser")
     **/
    protected $borrowIns;
    
    /**
     * @ORM\OneToMany(targetEntity="Borrow", mappedBy="lessor")
     **/
    protected $borrowOuts;
    
    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     **/
    protected $ratings;
    
    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->furnitures = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setFacebookId($id) {
        $this->facebook_id = $id;
    }
    
    public function getFacebookId() {
        return $this->facebook_id;
    }
    public function setFacebookAccessToken($id) {        
        $this->facebook_access_token = $id;
    }
    
    public function getFacebookAccessToken() {
        return $this->facebook_access_token;
    }
    
    public function getFullName() {
        return $this->getFirstName() . ' ' . $this->getLastName();
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("firstName")
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("lastName") 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return User
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("street")
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return User
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("streetNumber")
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return User
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("zip")
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return User
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("town")
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
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
     * Set gps
     *
     * @param string $gps
     * @return User
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get gps
     *
     * @return string 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("gps")
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Add furnitures
     *
     * @param \Ebus\MyBundle\Entity\Furniture $furnitures
     * @return User
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

    /**
     * Add ratings
     *
     * @param \Ebus\MyBundle\Entity\Rating $ratings
     * @return User
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
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add borrowIn
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrowIn
     * @return User
     */
    public function addBorrowIn(\Ebus\MyBundle\Entity\Borrow $borrowIn)
    {
        $this->borrowIn[] = $borrowIn;

        return $this;
    }

    /**
     * Remove borrowIn
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrowIn
     */
    public function removeBorrowIn(\Ebus\MyBundle\Entity\Borrow $borrowIn)
    {
        $this->borrowIn->removeElement($borrowIn);
    }

    /**
     * Get borrowIn
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBorrowIn()
    {
        return $this->borrowIn;
    }

    /**
     * Add borrowOut
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrowOut
     * @return User
     */
    public function addBorrowOut(\Ebus\MyBundle\Entity\Borrow $borrowOut)
    {
        $this->borrowOut[] = $borrowOut;

        return $this;
    }

    /**
     * Remove borrowOut
     *
     * @param \Ebus\MyBundle\Entity\Borrow $borrowOut
     */
    public function removeBorrowOut(\Ebus\MyBundle\Entity\Borrow $borrowOut)
    {
        $this->borrowOut->removeElement($borrowOut);
    }

    /**
     * Get borrowOut
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBorrowOut()
    {
        return $this->borrowOut;
    }

    /**
     * Get borrowIns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBorrowIns()
    {
        return $this->borrowIns;
    }

    /**
     * Get borrowOuts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBorrowOuts()
    {
        return $this->borrowOuts;
    }
    
    public function getAddress() {
        return $this->getStreet() . ' ' . $this->getStreetNumber() . ', ' . $this->getZip() . ' ' . $this->getTown();
    }
    
    public function hasAddress() {
        if($this->getStreet() == "")
            return false;
        if($this->getStreetNumber() == "")
            return false;
        if($this->getZip() == "")
            return false;
        if($this->getTown() == "")
            return false;
        
        return true;
    }
}
