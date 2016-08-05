<?php

namespace Strassen\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(type="string")
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
     *     targetEntity="Marker",
     *     mappedBy="category"
     * )
     */
    protected $markers;


    public function __construct()
    {
        $this->markers = new ArrayCollection();
        $this->color   = '#000';
        $this->weight  = 0;
    }

    /**
     * Gets the value of id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of shortdescription.
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }

    /**
     * Sets the value of shortdescription.
     *
     * @param string $shortdescription the shortdescription
     *
     * @return self
     */
    public function setShortdescription($shortdescription)
    {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    /**
     * Gets the value of fulldescription.
     *
     * @return string
     */
    public function getFulldescription()
    {
        return $this->fulldescription;
    }

    /**
     * Sets the value of fulldescription.
     *
     * @param string $fulldescription the fulldescription
     *
     * @return self
     */
    public function setFulldescription($fulldescription)
    {
        $this->fulldescription = $fulldescription;

        return $this;
    }

    /**
     * Gets the value of color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the value of color.
     *
     * @param string $color the color
     *
     * @return self
     */
    protected function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Gets the markers.
     *
     * @return ArrayCollection
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Sets the markers.
     *
     * @param  ArrayCollection $markers the markers
     *
     * @return self
     */
    public function setMarkers(ArrayCollection $markers)
    {
        $this->markers = $markers;

        return $this;
    }

    /**
     * Adds a Marker.
     *
     * @param  Marker $marker
     *
     * @return self
     */
    public function addMarker(Marker $marker)
    {
        if (!$this->markers->contains($marker)) {
            $this->markers->add($marker);
        }

        return $this;
    }

    /**
     * Removes a Marker.
     *
     * @param  Marker $marker
     *
     * @return self
     */
    public function removeMarker(Marker $marker)
    {
        $this->markers->removeElement($marker);

        return $this;
    }
}
