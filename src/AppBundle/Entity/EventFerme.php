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
    private $id;

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
     * @ORM\ManyToMany(targetEntity="Abonne", inversedBy="reservations")
     * @ORM\JoinTable(name="reservations")
     */
    private $abonnes;

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
}
