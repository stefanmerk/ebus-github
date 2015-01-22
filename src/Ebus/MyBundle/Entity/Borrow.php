<?php

namespace Ebus\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="borrow")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @JMS\ExclusionPolicy("all")
 */
class Borrow {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $dateFrom;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $dateUntil;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $accepted;    
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="borrowIns", fetch="EAGER")
     * @ORM\JoinColumn(name="leaser_id", referencedColumnName="id")
     **/
    protected $leaser;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="borrowOuts", fetch="EAGER")
     * @ORM\JoinColumn(name="lessor_id", referencedColumnName="id")
     **/
    protected $lessor;
    
    /**
     * @ORM\ManyToOne(targetEntity="Furniture", inversedBy="borrows", fetch="EAGER")
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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Borrow
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("dateFrom") 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateUntil
     *
     * @param \DateTime $dateUntil
     * @return Borrow
     */
    public function setDateUntil($dateUntil)
    {
        $this->dateUntil = $dateUntil;

        return $this;
    }

    /**
     * Get dateUntil
     *
     * @return \DateTime 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("dateUntil") 
     */
    public function getDateUntil()
    {
        return $this->dateUntil;
    }
    
    /**
     * Get days of rental 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("daysOfRental") 
     */
    public function getDaysOfRental() {
        return $this->dateUntil->diff($this->dateFrom)->format("%a");
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Borrow
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
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("price") 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     * @return Borrow
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("accepted") 
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set leaser
     *
     * @param \Ebus\MyBundle\Entity\User $leaser
     * @return Borrow
     */
    public function setLeaser(\Ebus\MyBundle\Entity\User $leaser = null)
    {
        $this->leaser = $leaser;

        return $this;
    }

    /**
     * Get leaser
     *
     * @return \Ebus\MyBundle\Entity\User 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("leaser") 
     */
    public function getLeaser()
    {
        return $this->leaser;
    }

    /**
     * Set lessor
     *
     * @param \Ebus\MyBundle\Entity\User $lessor
     * @return Borrow
     */
    public function setLessor(\Ebus\MyBundle\Entity\User $lessor = null)
    {
        $this->lessor = $lessor;

        return $this;
    }

    /**
     * Get lessor
     *
     * @return \Ebus\MyBundle\Entity\User 
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("lessor") 
     */
    public function getLessor()
    {
        return $this->lessor;
    }

    /**
     * Set furniture
     *
     * @param \Ebus\MyBundle\Entity\Furniture $furniture
     * @return Borrow
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
     * 
     * @JMS\VirtualProperty
     * @JMS\SerializedName("furniture") 
     */
    public function getFurniture()
    {
        return $this->furniture;
    }
    
    public function setTempPrice($pricePerDay) {
        $this->tempPrice = $pricePerDay;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate() {
        $this->calcPrice();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function beforePersist() {
        $this->calcPrice();
    }
    
    private function calcPrice() {
        $this->setPrice($this->getDaysOfRental() * $this->getFurniture()->getPrice());
    }
}
