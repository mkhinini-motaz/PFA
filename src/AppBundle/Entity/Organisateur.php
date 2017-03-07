<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organisateur
 *
 * @ORM\Table(name="organisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganisateurRepository")
 */
class Organisateur extends Abonne
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
     * @var string
     *
     * @ORM\Column(name="nomSociete", type="string", length=60, nullable=true)
     */
    private $nomSociete;

    /**
     * Relation entre Event et Organisateur
     * @ORM\OneToMany(targetEntity="Eventorganisateur", mappedBy="organisateurs")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $eventorganisateur;

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
     * Set nomSociete
     *
     * @param string $nomSociete
     *
     * @return Organisateur
     */
    public function setNomSociete($nomSociete)
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    /**
     * Get nomSociete
     *
     * @return string
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eventorganisateur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add eventorganisateur
     *
     * @param \AppBundle\Entity\Eventorganisateur $eventorganisateur
     *
     * @return Organisateur
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

    /**
     * Set compte
     *
     * @param \AppBundle\Entity\Compte $compte
     *
     * @return Organisateur
     */
    public function setCompte(\AppBundle\Entity\Compte $compte = null)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return \AppBundle\Entity\Compte
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservations $reservation
     *
     * @return Organisateur
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
}
