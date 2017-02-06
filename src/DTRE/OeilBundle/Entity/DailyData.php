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
     * @ORM\Column(name="id_sensor", type="integer")
     */
    private $idSensor;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set idSensor
     *
     * @param integer $idSensor
     *
     * @return DailyData
     */
    public function setIdSensor($idSensor)
    {
        $this->idSensor = $idSensor;

        return $this;
    }

    /**
     * Get idSensor
     *
     * @return int
     */
    public function getIdSensor()
    {
        return $this->idSensor;
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
