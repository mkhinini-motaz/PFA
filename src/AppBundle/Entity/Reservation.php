<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Reservation
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="dateCollecte", type="datetime")
     */
     private $dateCollecte;

     /**
      * @var \DateTime
      *
      * @ORM\Column(name="dateReservation", type="datetime")
      */
      private $dateReservation;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="reservations")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $eventFerme;

    /**
     * @ORM\ManyToOne(targetEntity="Abonne", inversedBy="reservations")
     * @ORM\JoinColumn(name="abonne_id", referencedColumnName="id")
     */
    protected $abonne;


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
     * @return Reservation
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
     * @return Reservation
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
     * @param \AppBundle\Entity\Event $eventFerme
     *
     * @return Reservation
     */
    public function setEventFerme(\AppBundle\Entity\Event $eventFerme = null)
    {
        $this->eventFerme = $eventFerme;

        return $this;
    }

    /**
     * Get eventFerme
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEventFerme()
    {
        return $this->eventFerme;
    }

    /**
     * Set abonnes
     *
     * @param \AppBundle\Entity\Abonne $abonnes
     *
     * @return Reservation
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

    /**
     * Set dateCollecte
     *
     * @param \DateTime $dateCollecte
     *
     * @return Reservation
     */
    public function setDateCollecte($dateCollecte)
    {
        $this->dateCollecte = $dateCollecte;

        return $this;
    }

    /**
     * Get dateCollecte
     *
     * @return \DateTime
     */
    public function getDateCollecte()
    {
        return $this->dateCollecte;
    }

    /**
     * Set abonne
     *
     * @param \AppBundle\Entity\Abonne $abonne
     *
     * @return Reservation
     */
    public function setAbonne(\AppBundle\Entity\Abonne $abonne = null)
    {
        $this->abonne = $abonne;

        return $this;
    }

    /**
     * Get abonne
     *
     * @return \AppBundle\Entity\Abonne
     */
    public function getAbonne()
    {
        return $this->abonne;
    }

    /**
    * @Assert\IsTrue(message = "La date de collecte des billets doit être supérieur à la date actuel")
    */
    public function isdateCollectValid()
    {
        if ($this->getEventFerme()->getGratuitCheck()) {
            return true;
        } else {
            return $this->getDateCollecte() > new \DateTime("now");
        }
    }
}
