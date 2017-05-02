<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vue
 *
 * @ORM\Table(name="vue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VueRepository")
 */
class Vue
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
     * Relation entre Vue et Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="vues")
     */
    private $event;

    /**
     * Relation entre Vue et Abonne
     * @ORM\OneToOne(targetEntity="Abonne")
     * @ORM\JoinColumn(name="abonne_id", referencedColumnName="id")
     */
    private $abonne;

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
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Vue
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
     * Set abonne
     *
     * @param \AppBundle\Entity\Abonne $abonne
     *
     * @return Vue
     */
    public function setAbonne(\AppBundle\Entity\Abonne $abonne = null)
    {
        $this->abonne = $abonne;

        return $this;
    }

    /**
     * Get abonne
     *
     * @return \AppBundle\Entity\Abonne
     */
    public function getAbonne()
    {
        return $this->abonne;
    }
}
