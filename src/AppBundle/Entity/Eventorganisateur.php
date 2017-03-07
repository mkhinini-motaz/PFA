<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eventorganisateur
 *
 * @ORM\Table(name="eventorganisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventorganisateurRepository")
 */
class Eventorganisateur
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventorganisateur")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="Organisateur", inversedBy="eventorganisateur")
     * @ORM\JoinColumn(name="organisateur_id", referencedColumnName="id")
     */
    private $organisateurs;

    public function __construct() {
        $this->events = new ArrayCollection();
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Eventorganisateur
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Eventorganisateur
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
}
