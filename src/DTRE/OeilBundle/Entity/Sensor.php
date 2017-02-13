<?php

namespace DTRE\OeilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sensor
 *
 * @ORM\Table(name="sensor")
 * @ORM\Entity(repositoryClass="DTRE\OeilBundle\Repository\SensorRepository")
 */
class Sensor
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity="DTRE\OeilBundle\Entity\Data", mappedBy="sensor" ,cascade={"persist", "remove"})
     */
    private $data;

    /**
     * @ORM\OneToMany(targetEntity="DTRE\OeilBundle\Entity\DailyData", mappedBy="sensor" ,cascade={"persist", "remove"})
     */
    private $dailydata;

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
     * Set name
     *
     * @param string $name
     *
     * @return Sensor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add datum
     *
     * @param \DTRE\OeilBundle\Entity\Data $datum
     *
     * @return Sensor
     */
    public function addDatum(\DTRE\OeilBundle\Entity\Data $datum)
    {
        $this->data[] = $datum;

        $datum->setSensor($this);

        return $this;
    }

    /**
     * Remove datum
     *
     * @param \DTRE\OeilBundle\Entity\Data $datum
     */
    public function removeDatum(\DTRE\OeilBundle\Entity\Data $datum)
    {
        $this->data->removeElement($datum);
    }

    /**
     * Get data
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Add dailydatum
     *
     * @param \DTRE\OeilBundle\Entity\DailyData $dailydatum
     *
     * @return Sensor
     */
    public function addDailydatum(\DTRE\OeilBundle\Entity\DailyData $dailydatum)
    {
        $this->dailydata[] = $dailydatum;

        $dailydatum->setSensor($this);

        return $this;
    }

    /**
     * Remove dailydatum
     *
     * @param \DTRE\OeilBundle\Entity\DailyData $dailydatum
     */
    public function removeDailydatum(\DTRE\OeilBundle\Entity\DailyData $dailydatum)
    {
        $this->dailydata->removeElement($dailydatum);
    }

    /**
     * Get dailydata
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDailydata()
    {
        return $this->dailydata;
    }
}
