<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="nom", type="string", length=60)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=100, nullable=true)
     */
    protected $lieu;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\GreaterThanOrEqual("today UTC")
     */
    protected $date;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    protected $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=60, nullable=true)
     * @Assert\Image
     */
    protected $photo;

    /**
     * @var array
     *
     * @ORM\Column(name="fichiers", type="array", nullable=true)
     */
    protected $fichiers;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer", nullable=true)
     */
    private $capacite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebutInscri", type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual("today UTC")
     */
    private $dateDebutInscri;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFinInscri", type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual("today UTC")
     */
    private $dateFinInscri;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=3, nullable=true)
     */
    private $prix;

    /**
     * Relation entre Event et Categorie
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="events")
     * @ORM\JoinTable(name="eventcategorie")
     */
    protected $categories;

    /**
     * Relation entre Event et Sponsor
     * @ORM\OneToMany(targetEntity="Sponsoring", mappedBy="events")
     * @ORM\JoinTable(name="sponsoring")
     */
    protected $sponsoring;

    /**
     * Relation entre Event et Organisateur
     * @ORM\OneToMany(targetEntity="Eventorganisateur", mappedBy="events")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $eventorganisateur;

    /**
     * Relation entre Abonne et Event
     * @ORM\ManyToMany(targetEntity="Abonne", mappedBy="eventsParticipe")
     * @ORM\JoinTable(name="participations")
     */
    protected $participants;

    /**
     * Relation entre EventFerme et Abonne
     * @ORM\OneToMany(targetEntity="Reservations", mappedBy="eventsFerme")
     * @ORM\JoinTable(name="reservations")
     */
    private $reservations;


    public function __construct() {
        $this->categories = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Event
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Event
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Event
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set fichiers
     *
     * @param array $fichiers
     *
     * @return Event
     */
    public function setFichiers($fichiers)
    {
        $this->fichiers = $fichiers;

        return $this;
    }

    /**
     * Get fichiers
     *
     * @return array
     */
    public function getFichiers()
    {
        return $this->fichiers;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Categorie $category
     *
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
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
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Event
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set capacite
     *
     * @param integer $capacite
     *
     * @return Event
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * Get capacite
     *
     * @return integer
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
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * Add participant
     *
     * @param \AppBundle\Entity\Abonne $participant
     *
     * @return Event
     */
    public function addParticipant(\AppBundle\Entity\Abonne $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param \AppBundle\Entity\Abonne $participant
     */
    public function removeParticipant(\AppBundle\Entity\Abonne $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservations $reservation
     *
     * @return Event
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
