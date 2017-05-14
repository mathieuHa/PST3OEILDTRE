<?php

namespace DTRE\OeilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Image
 *
 * @ORM\Table(name="image")
 *
 * @ORM\Entity(repositoryClass="DTRE\OeilBundle\Repository\ImageRepository")
 *
 * @ExclusionPolicy("all")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Expose
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Expose
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="urlth", type="string", length=255)
     * @Expose
     */
    private $urlth;

    /**
     * @ORM\ManyToOne(targetEntity="DTRE\OeilBundle\Entity\User")
     * @Expose
     */
    private $user;




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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Image
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
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Image
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set urlth
     *
     * @param string $urlth
     *
     * @return Image
     */
    public function setUrlth($urlth)
    {
        $this->urlth = $urlth;

        return $this;
    }

    /**
     * Get urlth
     *
     * @return string
     */
    public function getUrlth()
    {
        return $this->urlth;
    }

    /**
     * Set user
     *
     * @param \DTRE\OeilBundle\Entity\User $user
     *
     * @return Image
     */
    public function setUser(\DTRE\OeilBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DTRE\OeilBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
