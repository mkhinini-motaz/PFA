<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eventsponsor
 *
 * @ORM\Table(name="sponsoring")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventsponsorRepository")
 */
class Sponsoring
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
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=9, scale=3)
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="sponsoring")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $events;

    /**
     * @ORM\ManyToOne(targetEntity="Sponsor", inversedBy="sponsoring")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")
     */
    protected $sponsors;

    public function __construct() {
        $this->events = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
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
     * Set montant
     *
     * @param string $montant
     *
     * @return Eventsponsor
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set events
     *
     * @param \AppBundle\Entity\Event $events
     *
     * @return Sponsoring
     */
    public function setEvents(\AppBundle\Entity\Event $events = null)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set sponsors
     *
     * @param \AppBundle\Entity\Sponsor $sponsors
     *
     * @return Sponsoring
     */
    public function setSponsors(\AppBundle\Entity\Sponsor $sponsors = null)
    {
        $this->sponsors = $sponsors;

        return $this;
    }

    /**
     * Get sponsors
     *
     * @return \AppBundle\Entity\Sponsor
     */
    public function getSponsors()
    {
        return $this->sponsors;
    }
}
