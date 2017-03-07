<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * EventFerme
 *
 * @ORM\Table(name="event_ferme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventFermeRepository")
 */
class EventFerme extends Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer")
     */
    private $capacite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebutInscri", type="datetime")
     */
    private $dateDebutInscri;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFinInscri", type="datetime")
     */
    private $dateFinInscri;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=3)
     */
    private $prix;

    /**
     * Relation entre EventFerme et Abonne
     * @ORM\OneToMany(targetEntity="Reservations", mappedBy="eventsFerme")
     * @ORM\JoinTable(name="reservations")
     */
    private $reservations;

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
     * Set capacite
     *
     * @param integer $capacite
     *
     * @return EventFerme
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * Get capacite
     *
     * @return int
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Set dateDebutInscri
     *
     * @param \DateTime $dateDebutInscri
     *
     * @return EventFerme
     */
    public function setDateDebutInscri($dateDebutInscri)
    {
        $this->dateDebutInscri = $dateDebutInscri;

        return $this;
    }

    /**
     * Get dateDebutInscri
     *
     * @return \DateTime
     */
    public function getDateDebutInscri()
    {
        return $this->dateDebutInscri;
    }

    /**
     * Set dateFinInscri
     *
     * @param \DateTime $dateFinInscri
     *
     * @return EventFerme
     */
    public function setDateFinInscri($dateFinInscri)
    {
        $this->dateFinInscri = $dateFinInscri;

        return $this;
    }

    /**
     * Get dateFinInscri
     *
     * @return \DateTime
     */
    public function getDateFinInscri()
    {
        return $this->dateFinInscri;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return EventFerme
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservations $reservation
     *
     * @return EventFerme
     */
    public function addReservation(\AppBundle\Entity\Reservations $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\Reservations $reservation
     */
    public function removeReservation(\AppBundle\Entity\Reservations $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Categorie $category
     *
     * @return EventFerme
     */
    public function addCategory(\AppBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Categorie $category
     */
    public function removeCategory(\AppBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add sponsoring
     *
     * @param \AppBundle\Entity\Sponsoring $sponsoring
     *
     * @return EventFerme
     */
    public function addSponsoring(\AppBundle\Entity\Sponsoring $sponsoring)
    {
        $this->sponsoring[] = $sponsoring;

        return $this;
    }

    /**
     * Remove sponsoring
     *
     * @param \AppBundle\Entity\Sponsoring $sponsoring
     */
    public function removeSponsoring(\AppBundle\Entity\Sponsoring $sponsoring)
    {
        $this->sponsoring->removeElement($sponsoring);
    }

    /**
     * Get sponsoring
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSponsoring()
    {
        return $this->sponsoring;
    }

    /**
     * Add eventorganisateur
     *
     * @param \AppBundle\Entity\Eventorganisateur $eventorganisateur
     *
     * @return EventFerme
     */
    public function addEventorganisateur(\AppBundle\Entity\Eventorganisateur $eventorganisateur)
    {
        $this->eventorganisateur[] = $eventorganisateur;

        return $this;
    }

    /**
     * Remove eventorganisateur
     *
     * @param \AppBundle\Entity\Eventorganisateur $eventorganisateur
     */
    public function removeEventorganisateur(\AppBundle\Entity\Eventorganisateur $eventorganisateur)
    {
        $this->eventorganisateur->removeElement($eventorganisateur);
    }

    /**
     * Get eventorganisateur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventorganisateur()
    {
        return $this->eventorganisateur;
    }
}
