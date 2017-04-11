<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationsRepository")
 */
class Reservations
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
     * @ORM\Column(name="nbrPlaces", type="integer")
     */
    private $nbrPlaces;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReservation", type="datetime")
     */
    private $dateReservation;

    /**
     * @ORM\ManyToOne(targetEntity="EventFerme", inversedBy="reservations")
     * @ORM\JoinColumn(name="eventferme_id", referencedColumnName="id")
     */
    protected $eventsFerme;

    /**
     * @ORM\ManyToOne(targetEntity="Abonne", inversedBy="reservations")
     * @ORM\JoinColumn(name="abonne_id", referencedColumnName="id")
     */
    protected $abonnes;

    public function __construct() {
        $this->abonnes = new ArrayCollection();
    }

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
     * Set nbrPlaces
     *
     * @param integer $nbrPlaces
     *
     * @return Reservations
     */
    public function setNbrPlaces($nbrPlaces)
    {
        $this->nbrPlaces = $nbrPlaces;

        return $this;
    }

    /**
     * Get nbrPlaces
     *
     * @return int
     */
    public function getNbrPlaces()
    {
        return $this->nbrPlaces;
    }

    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Reservations
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set eventsFerme
     *
     * @param \AppBundle\Entity\EventFerme $eventsFerme
     *
     * @return Reservations
     */
    public function setEventsFerme(\AppBundle\Entity\EventFerme $eventsFerme = null)
    {
        $this->eventsFerme = $eventsFerme;

        return $this;
    }

    /**
     * Get eventsFerme
     *
     * @return \AppBundle\Entity\EventFerme
     */
    public function getEventsFerme()
    {
        return $this->eventsFerme;
    }

    /**
     * Set abonnes
     *
     * @param \AppBundle\Entity\Abonne $abonnes
     *
     * @return Reservations
     */
    public function setAbonnes(\AppBundle\Entity\Abonne $abonnes = null)
    {
        $this->abonnes = $abonnes;

        return $this;
    }

    /**
     * Get abonnes
     *
     * @return \AppBundle\Entity\Abonne
     */
    public function getAbonnes()
    {
        return $this->abonnes;
    }
}
