<?php

namespace DTRE\OeilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyData
 *
 * @ORM\Table(name="daily_data")
 * @ORM\Entity(repositoryClass="DTRE\OeilBundle\Repository\DailyDataRepository")
 */
class DailyData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="minvalue", type="integer")
     */
    private $minvalue;

    /**
     * @var int
     *
     * @ORM\Column(name="maxvalue", type="integer")
     */
    private $maxvalue;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="DTRE\OeilBundle\Entity\Sensor", inversedBy="dailydata")
     */
    private $sensor;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return DailyData
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @ORM\Column(name="date", type="date")
     */

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set sensor
     *
     * @param \DTRE\OeilBundle\Entity\Sensor $sensor
     *
     * @return DailyData
     */
    public function setSensor(\DTRE\OeilBundle\Entity\Sensor $sensor = null)
    {
        $this->sensor = $sensor;

        return $this;
    }

    /**
     * Get sensor
     *
     * @return \DTRE\OeilBundle\Entity\Sensor
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * Set minvalue
     *
     * @param integer $minvalue
     *
     * @return DailyData
     */
    public function setMinvalue($minvalue)
    {
        $this->minvalue = $minvalue;

        return $this;
    }

    /**
     * Get minvalue
     *
     * @return integer
     */
    public function getMinvalue()
    {
        return $this->minvalue;
    }

    /**
     * Set maxvalue
     *
     * @param integer $maxvalue
     *
     * @return DailyData
     */
    public function setMaxvalue($maxvalue)
    {
        $this->maxvalue = $maxvalue;

        return $this;
    }

    /**
     * Get maxvalue
     *
     * @return integer
     */
    public function getMaxvalue()
    {
        return $this->maxvalue;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return DailyData
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
}
