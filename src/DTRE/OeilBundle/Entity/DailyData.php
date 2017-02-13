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
}
