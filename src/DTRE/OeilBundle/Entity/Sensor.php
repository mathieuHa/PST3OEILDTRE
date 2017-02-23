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
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string")
     */
    private $subtitle;




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
        $this->dailydata = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set data
     *
     * @return Sensor
     */
    public function setData($data)
    {
        $this->data = $data;
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
     * Get dailydata
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDailydata()
    {
        return $this->dailydata;
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
     * Set title
     *
     * @param string $title
     *
     * @return Sensor
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Sensor
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }
}
