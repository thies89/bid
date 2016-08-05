<?php

namespace Strassen\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Marker
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
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $addressInfo;

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
     * @var Category
     *
     * @ORM\ManyToOne(
     *     targetEntity="Category",
     *     inversedBy="markers",
     * )
     * @ORM\JoinColumn(
     *     name="category_id",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     * @Assert\NotBlank()
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $usageType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email(
     *     checkMX = true
     * )
     */
    protected $contact;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $contactUse;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $own;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $source;

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
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    protected $flatAttr;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numberFlat;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numberInd;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $price;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $size;

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

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $checked;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->checked   = false;
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
     * Gets the value of address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the value of address.
     *
     * @param string $address the address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets the value of addressInfo.
     *
     * @return string
     */
    public function getAddressInfo()
    {
        return $this->addressInfo;
    }

    /**
     * Sets the value of addressInfo.
     *
     * @param string $addressInfo the address info
     *
     * @return self
     */
    public function setAddressInfo($addressInfo)
    {
        $this->addressInfo = $addressInfo;

        return $this;
    }

    /**
     * Gets the value of lat.
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Gets the value of lat obfuscated.
     *
     * @return float
     */
    public function getLatObfuscated()
    {
        return $this->obfuscate($this->lat);
    }

    /**
     * Sets the value of lat.
     *
     * @param float $lat the lat
     *
     * @return self
     */
    public function setLat($lat)
    {
        $this->lat = $this->obfuscate($lat);

        return $this;
    }

    /**
     * Gets the value of lng.
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Gets the value of lng obfuscated.
     *
     * @return float
     */
    public function getLngObfuscated()
    {
        return $this->obfuscate($this->lng);
    }

    /**
     * Sets the value of lng.
     *
     * @param float $lng the lng
     *
     * @return self
     */
    public function setLng($lng)
    {
        $this->lng = $this->obfuscate($lng);

        return $this;
    }

    /**
     * Gets the Category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the Category
     *
     * @param Category $category the category
     *
     * @return self
     */
    public function setCategory(Category $category)
    {
        $category->addMarker($this);
        $this->category = $category;

        return $this;
    }

    /**
     * Gets the value of usageType.
     *
     * @return string
     */
    public function getUsageType()
    {
        return $this->usageType;
    }

    /**
     * Sets the value of usageType.
     *
     * @param string $usageType the usageType
     *
     * @return self
     */
    public function setUsageType($usageType)
    {
        $this->usageType = $usageType;

        return $this;
    }

    /**
     * Gets the value of contact.
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Sets the value of contact.
     *
     * @param string $contact the contact
     *
     * @return self
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Gets the value of contactUse.
     *
     * @return array
     */
    public function getContactUse()
    {
        return $this->contactUse;
    }

    /**
     * Sets the value of contactUse.
     *
     * @param array $contactUse the contact use
     *
     * @return self
     */
    public function setContactUse(array $contactUse)
    {
        $this->contactUse = $contactUse;

        return $this;
    }

    /**
     * Gets the value of own.
     *
     * @return string
     */
    public function getOwn()
    {
        return $this->own;
    }

    /**
     * Sets the value of own.
     *
     * @param string $own the own
     *
     * @return self
     */
    public function setOwn($own)
    {
        $this->own = $own;

        return $this;
    }

    /**
     * Gets the value of source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets the value of source.
     *
     * @param string $source the source
     *
     * @return self
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Gets the value of startY.
     *
     * @return int
     */
    public function getStartY()
    {
        return $this->startY;
    }

    /**
     * Sets the value of startY.
     *
     * @param int $startY the start
     *
     * @return self
     */
    public function setStartY($startY)
    {
        $this->startY = $startY;

        return $this;
    }

    /**
     * Gets the value of endY.
     *
     * @return int
     */
    public function getEndY()
    {
        return $this->endY;
    }

    /**
     * Sets the value of endY.
     *
     * @param int $endY the end
     *
     * @return self
     */
    public function setEndY($endY)
    {
        $this->endY = $endY;

        return $this;
    }

    /**
     * Gets the value of flatAttr.
     *
     * @return array
     */
    public function getFlatAttr()
    {
        return $this->flatAttr;
    }

    /**
     * Sets the value of flatAttr.
     *
     * @param array $flatAttr the flat attr
     *
     * @return self
     */
    public function setFlatAttr(array $flatAttr)
    {
        $this->flatAttr = $flatAttr;

        return $this;
    }

    /**
     * Gets the value of numberFlat.
     *
     * @return int
     */
    public function getNumberFlat()
    {
        return $this->numberFlat;
    }

    /**
     * Sets the value of numberFlat.
     *
     * @param int $numberFlat the number flat
     *
     * @return self
     */
    public function setNumberFlat($numberFlat)
    {
        $this->numberFlat = $numberFlat;

        return $this;
    }

    /**
     * Gets the value of numberInd.
     *
     * @return int
     */
    public function getNumberInd()
    {
        return $this->numberInd;
    }

    /**
     * Sets the value of numberInd.
     *
     * @param int $numberInd the number ind
     *
     * @return self
     */
    public function setNumberInd($numberInd)
    {
        $this->numberInd = $numberInd;

        return $this;
    }

    /**
     * Gets the value of price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the value of price.
     *
     * @param float $price the price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Gets the value of size.
     *
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets the value of size.
     *
     * @param float $size the size
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Gets the value of comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the value of comment.
     *
     * @param string $comment the comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Gets the value of createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the value of createdAt.
     *
     * @param \DateTime $createdAt the created at
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets the value of checked.
     *
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
    }

    /**
     * Sets the value of checked.
     *
     * @param bool $checked the checked
     *
     * @return self
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }


    /**
     * Obfuscate a coordinate
     *
     * @param  float $coordinate
     *
     * @return float
     */
    private function obfuscate($coordinate) {
        if (rand(0, 1) < 0.5) {
            return $coordinate + ((float) rand(0, 500) - 500) / 2000000;
        }

        return $coordinate - ( (float) rand(0, 500) - 500) / 2000000;
    }
}
