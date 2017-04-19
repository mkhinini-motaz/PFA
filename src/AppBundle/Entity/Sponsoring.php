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
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="Sponsor", inversedBy="sponsoring")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")
     */
    protected $sponsor;

    public function __construct() {

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
     * @param \AppBundle\Entity\Event $event
     *
     * @return Sponsoring
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set sponsor
     *
     * @param \AppBundle\Entity\Sponsor $sponsor
     *
     * @return Sponsoring
     */
    public function setSponsor(\AppBundle\Entity\Sponsor $sponsor = null)
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * Get sponsor
     *
     * @return \AppBundle\Entity\Sponsor
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }
}
