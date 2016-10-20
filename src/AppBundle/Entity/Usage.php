<?php

namespace Strassen\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="`usage`")
 */
class Usage
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Strassen\AppBundle\Entity\Usage")
     */
    protected $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $shortdescription;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $fulldescription;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $color;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $weight;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Business",
     *     mappedBy="usage"
     * )
     */
    protected $business;


    public function __construct()
    {
        $this->business = new ArrayCollection();
        $this->color   = '#000';
        $this->weight  = 0;
    }



    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the Usage
     *
     * @return Usage
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the Usage
     *
     * @param Usage parent
     *
     * @return self
     */
    public function setParent(Usage $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Shortdescription
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }

    /**
     * Set the value of Shortdescription
     *
     * @param string shortdescription
     *
     * @return self
     */
    public function setShortdescription($shortdescription)
    {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    /**
     * Get the value of Fulldescription
     *
     * @return string
     */
    public function getFulldescription()
    {
        return $this->fulldescription;
    }

    /**
     * Set the value of Fulldescription
     *
     * @param string fulldescription
     *
     * @return self
     */
    public function setFulldescription($fulldescription)
    {
        $this->fulldescription = $fulldescription;

        return $this;
    }

    /**
     * Get the value of Color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of Color
     *
     * @param string color
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of Weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of Weight
     *
     * @param int weight
     *
     * @return self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of Business
     *
     * @return ArrayCollection
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * Set the value of Business
     *
     * @param ArrayCollection business
     *
     * @return self
     */
    public function setBusiness(ArrayCollection $business)
    {
        $this->business = $business;

        return $this;
    }

}
