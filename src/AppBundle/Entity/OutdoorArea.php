<?php

namespace Strassen\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="outdoorarea")
 */
class OutdoorArea
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
      * @ORM\Column(type="integer", nullable=true)
      */
     protected $seats;

     /**
      * @var int
      *
      * @ORM\Column(type="integer", nullable=true)
      */
     protected $barTable;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
     protected $roof;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
     protected $railings;

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
     * Get the value of Seats
     *
     * @return int
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Set the value of Seats
     *
     * @param int seats
     *
     * @return self
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * Get the value of Bar Table
     *
     * @return int
     */
    public function getBarTable()
    {
        return $this->barTable;
    }

    /**
     * Get the value of Bar Table
     *
     * @return int
     */
    public function getBarPlaces()
    {
        $barPlaces = 4*$this->barTable;
        return $barPlaces;
    }

    /**
     * Set the value of Bar Table
     *
     * @param int barTable
     *
     * @return self
     */
    public function setBarTable($barTable)
    {
        $this->barTable = $barTable;

        return $this;
    }

    /**
     * Get the value of Roof
     *
     * @return bool
     */
    public function getRoof()
    {
        return $this->roof;
    }

    /**
     * Set the value of Roof
     *
     * @param bool roof
     *
     * @return self
     */
    public function setRoof($roof)
    {
        $this->roof = $roof;

        return $this;
    }

    /**
     * Get the value of Railings
     *
     * @return bool
     */
    public function getRailings()
    {
        return $this->railings;
    }

    /**
     * Set the value of Railings
     *
     * @param bool railings
     *
     * @return self
     */
    public function setRailings($railings)
    {
        $this->railings = $railings;

        return $this;
    }

}
