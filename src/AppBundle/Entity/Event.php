<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"event" = "Event", "eventferme" = "EventFerme"})
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
}
