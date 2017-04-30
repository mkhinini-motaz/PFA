<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abonne
 *
 * @ORM\Table(name="abonne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbonneRepository")
 */
class Abonne
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
     * @ORM\Column(name="nom", type="string", length=60, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=60, nullable=true)
     */
    private $prenom;

    /**
     * @var date
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * Relation entre Abonne et son Compte
     * @ORM\OneToOne(targetEntity="Compte", inversedBy="abonne")
     * @ORM\JoinColumn(name="compte_id", referencedColumnName="id")
     */
    private $compte;

    /**
     * Relation entre Abonne et Event
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="participants")
     * @ORM\JoinTable(name="participations")
     */
    private $eventsParticipe;

    /**
     * Relation entre Abonne et Event
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="abonne")
     * @ORM\JoinTable(name="reservations")
     */
    private $reservations;

    /**
     * @var string
     *
     * @ORM\Column(name="nomSociete", type="string", length=60, nullable=true)
     */
    private $nomSociete;

    /**
     * Relation entre Event et Organisateur
     * @ORM\OneToMany(targetEntity="Event", mappedBy="organisateur")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Abonne
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Abonne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Abonne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Abonne
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set compte
     *
     * @param \AppBundle\Entity\Compte $compte
     *
     * @return Abonne
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
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Abonne
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
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Abonne
     */
    public function setEmail($email)
    {
        $this->getCompte()->setEmail($email);

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getCompte()->getEmail();
    }

    /**
     * Add eventsParticipe
     *
     * @param \AppBundle\Entity\Event $eventsParticipe
     *
     * @return Abonne
     */
    public function addEventsParticipe(\AppBundle\Entity\Event $eventsParticipe)
    {
        $this->eventsParticipe[] = $eventsParticipe;

        return $this;
    }

    /**
     * Remove eventsParticipe
     *
     * @param \AppBundle\Entity\Event $eventsParticipe
     */
    public function removeEventsParticipe(\AppBundle\Entity\Event $eventsParticipe)
    {
        $this->eventsParticipe->removeElement($eventsParticipe);
    }

    /**
     * Get eventsParticipe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventsParticipe()
    {
        return $this->eventsParticipe;
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
     * @return string
     *
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }

    /**
    * @Assert\IsTrue(message = "Le numéro de téléphone saisi est invalide")
    */
    public function isValidTel()
    {
        if($this->getTelephone() == null)
            return true;
        $tel = str_replace(" ", "", $this->getTelephone());
        if($tel[0] == '+')
        {
            $tel = substr($tel,1);

            if (strlen($tel) != 11)
              return false;
            if (substr($tel, 0, 3) != "216")
              return false;

            $tel = substr($tel, 3);
        }
        elseif (substr($tel, 0, 2) == "00") {
            if (substr($tel, 2, 3) != "216")
                return false;
            if (strlen($tel) != 13)
                return false;

            $tel = substr($tel,5);
        }
        else {
        if (strlen($tel) != 8)
          return false;
        }
        if (!ctype_digit($tel))
            return false;
        if (in_array($tel[0], ['0', '1', '6', '8']))
            return false;

        $this->setTelephone($tel);
        return true;
    }


    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Abonne
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
