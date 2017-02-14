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
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var int
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\Column(name="date", type="datetime")
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DailyData
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

    /**
     * Set min
     *
     * @param integer $min
     *
     * @return DailyData
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     *
     * @return DailyData
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }
}
