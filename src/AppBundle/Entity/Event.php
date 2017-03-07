<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=60, nullable=true)
     */
    protected $photo;

    /**
     * @var array
     *
     * @ORM\Column(name="fichiers", type="array", nullable=true)
     */
    protected $fichiers;

    /**
     * Relation entre Event et Categorie
     * @ORM\OneToMany(targetEntity="Categorie", inversedBy="events")
     * @ORM\JoinTable(name="eventcategorie")
     */
    protected $categories;


    /**
     * Relation entre Event et Sponsor
     * @ORM\ManyToMany(targetEntity="Sponsor", inversedBy="events")
     * @ORM\JoinTable(name="eventsponsor")
     */
    protected $sponsors;

    /**
     * Relation entre Event et Organisateur
     * @ORM\ManyToMany(targetEntity="Organisateur", inversedBy="events")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $organisateurs;

    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->organisateurs = new ArrayCollection();
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
}
