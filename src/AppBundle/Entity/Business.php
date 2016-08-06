<?php

namespace Strassen\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Business
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
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $addressInfo;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $levels;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $lat;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $lng;

    /**
     * @var Usage
     *
     * @ORM\ManyToOne(
     *     targetEntity="Usage",
     *     inversedBy="business",
     * )
     * @ORM\JoinColumn(
     *     name="usage_id",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     * @Assert\NotBlank()
     */
    protected $usage;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $inhabited;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $moreIndustry;

    /**
     * @var OutdoorArea
     *
     * @ORM\ManyToOne(
     *     targetEntity="OutdoorArea",
     *     inversedBy="business",
     * )
     * @ORM\JoinColumn(
     *     name="outdoorarea_id",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     * @Assert\NotBlank()
     */
    protected $outdoorArea;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $branded;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $startY;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $endY;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->checked   = false;
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
     * Get the value of Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of Label
     *
     * @param string label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of Address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param string address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of Address Info
     *
     * @return string
     */
    public function getAddressInfo()
    {
        return $this->addressInfo;
    }

    /**
     * Set the value of Address Info
     *
     * @param string addressInfo
     *
     * @return self
     */
    public function setAddressInfo($addressInfo)
    {
        $this->addressInfo = $addressInfo;

        return $this;
    }

    /**
     * Get the value of Levels
     *
     * @return int
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set the value of Levels
     *
     * @param int levels
     *
     * @return self
     */
    public function setLevels($levels)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Get the value of Lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set the value of Lat
     *
     * @param float lat
     *
     * @return self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get the value of Lng
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set the value of Lng
     *
     * @param float lng
     *
     * @return self
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get the value of Usage
     *
     * @return Usage
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * Set the value of Usage
     *
     * @param Usage usage
     *
     * @return self
     */
    public function setUsage(Usage $usage)
    {
        $this->usage = $usage;

        return $this;
    }

    /**
     * Get the value of Inhabited
     *
     * @return bool
     */
    public function getInhabited()
    {
        return $this->inhabited;
    }

    /**
     * Set the value of Inhabited
     *
     * @param bool inhabited
     *
     * @return self
     */
    public function setInhabited($inhabited)
    {
        $this->inhabited = $inhabited;

        return $this;
    }

    /**
     * Get the value of More Industry
     *
     * @return bool
     */
    public function getMoreIndustry()
    {
        return $this->moreIndustry;
    }

    /**
     * Set the value of More Industry
     *
     * @param bool moreIndustry
     *
     * @return self
     */
    public function setMoreIndustry($moreIndustry)
    {
        $this->moreIndustry = $moreIndustry;

        return $this;
    }

    /**
     * Get the value of Outdoor Area
     *
     * @return OutdoorArea
     */
    public function getOutdoorArea()
    {
        return $this->outdoorArea;
    }

    /**
     * Set the value of Outdoor Area
     *
     * @param OutdoorArea outdoorArea
     *
     * @return self
     */
    public function setOutdoorArea(OutdoorArea $outdoorArea)
    {
        $this->outdoorArea = $outdoorArea;

        return $this;
    }

    /**
     * Get the value of Branded
     *
     * @return bool
     */
    public function getBranded()
    {
        return $this->branded;
    }

    /**
     * Set the value of Branded
     *
     * @param bool branded
     *
     * @return self
     */
    public function setBranded($branded)
    {
        $this->branded = $branded;

        return $this;
    }

    /**
     * Get the value of Start
     *
     * @return int
     */
    public function getStartY()
    {
        return $this->startY;
    }

    /**
     * Set the value of Start
     *
     * @param int startY
     *
     * @return self
     */
    public function setStartY($startY)
    {
        $this->startY = $startY;

        return $this;
    }

    /**
     * Get the value of End
     *
     * @return int
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * Set the value of End
     *
     * @param int endY
     *
     * @return self
     */
    public function setEndY($endY)
    {
        $this->endY = $endY;

        return $this;
    }

    /**
     * Get the value of Comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of Comment
     *
     * @param string comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param \DateTime createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
