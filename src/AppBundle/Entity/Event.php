<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @Assert\GroupSequenceProvider
 */
class Event implements GroupSequenceProviderInterface
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
     * @Assert\NotNull(message = "Un évennement ne peut pas être sans nom")
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
     * @Assert\GreaterThanOrEqual(value = "+0 hours UTC")
     */
    protected $date;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual(value = "+0 hours UTC")
     */
    protected $dateFin;


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
     * @Assert\GreaterThanOrEqual("0", groups = {"eventferme"})
     */
    private $capacite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_inscri", type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual("today UTC", groups = {"eventferme"})
     */
    private $dateDebutInscri;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_inscri", type="datetime", nullable=true)
     * @Assert\GreaterThanOrEqual("today UTC", groups = {"eventferme"})
     */
    private $dateFinInscri;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=3, nullable=true)
     * @Assert\GreaterThan(value = 0, message = "Le prix ne peut pas être négatif", groups = {"eventpayant"})
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
     * @ORM\OneToMany(targetEntity="Sponsoring", mappedBy="event")
     * @ORM\JoinTable(name="sponsoring")
     */
    protected $sponsoring;

    /**
     * Relation entre Event et Organisateur
     * @ORM\ManyToOne(targetEntity="Abonne", inversedBy="events")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $organisateur;

    /**
     * Relation entre Abonne et Event
     * @ORM\ManyToMany(targetEntity="Abonne", mappedBy="eventsParticipe")
     * @ORM\JoinTable(name="participations")
     */
    protected $participants;

    /**
     * Relation entre EventFerme et Abonne
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="eventFerme")
     * @ORM\JoinTable(name="reservations")
     */
    private $reservations;

    /**
     * @ORM\Column(name="ouvertCheck", type="boolean", nullable=true)
     */
    private $ouvertCheck;

    /**
    * @ORM\Column(name="gratuitCheck", type="boolean", nullable=true)
    */
    private $gratuitCheck;

    /**
    * @ORM\Column(name="nbr_vue", type="integer", nullable=true)
    */
    private $nbrVue = 0;

    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->sponsoring = new ArrayCollection();
        $this->eventorganisateurs = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Event
     */
    public function addReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set ouvertCheck
     *
     * @param boolean $ouvertCheck
     *
     * @return Event
     */
    public function setOuvertCheck($ouvertCheck)
    {
        $this->ouvertCheck = $ouvertCheck;

        return $this;
    }

    /**
     * Get ouvertCheck
     *
     * @return boolean
     */
    public function getOuvertCheck()
    {
        return $this->ouvertCheck;
    }

    /**
     * Set gratuitCheck
     *
     * @param boolean $gratuitCheck
     *
     * @return Event
     */
    public function setGratuitCheck($gratuitCheck)
    {
        $this->gratuitCheck = $gratuitCheck;

        return $this;
    }

    /**
     * Get gratuitCheck
     *
     * @return boolean
     */
    public function getGratuitCheck()
    {
        return $this->gratuitCheck;
    }

    public function getGroupSequence(){
            $groups = ['Default', 'Event'];

            if(!$this->getOuvertCheck())
            {
                $groups[] = 'eventferme';
            }

            if(!$this->getGratuitCheck())
            {
                $groups[] = 'eventpayant';
            }

            return $groups;
    }


    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Event
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set organisateur
     *
     * @param \AppBundle\Entity\Abonne $organisateur
     *
     * @return Event
     */
    public function setOrganisateur(\AppBundle\Entity\Abonne $organisateur = null)
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * Get organisateur
     *
     * @return \AppBundle\Entity\Abonne
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    public function checkReservation(\AppBundle\Entity\Abonne $abonne)
    {
        $reservations = $this->getReservations();
        foreach ($reservations as $reservation) {
            if ($reservation->getAbonne() == $abonne) {
                return true;
            }
        }
        return false;
    }

    public function incrementNbrVue()
    {
        $this->nbrVue++;
    }

}
