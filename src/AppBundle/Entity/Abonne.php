<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abonne
 *
 * @ORM\Table(name="abonne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbonneRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"abonne" = "Abonne", "organisateur" = "Organisateur"})
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
     * @ORM\Column(name="prenom", type="string", length=60)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    protected $telephone;

    /**
     * Relation entre Abonne et son Compte
     * @ORM\OneToOne(targetEntity="Compte", inversedBy="abonne")
     * @ORM\JoinColumn(name="compte_id", referencedColumnName="id")
     */
    protected $compte;

    /**
     * Relation entre Abonne et EventFerme
     * @ORM\OneToMany(targetEntity="Reservations", mappedBy="abonnes")
     * @ORM\JoinTable(name="reservations")
     */
    protected $reservations;

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
     * Set email
     *
     * @param string $email
     *
     * @return Abonne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \AppBundle\Entity\Reservations $reservation
     *
     * @return Abonne
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

    /**
    * @Assert\IsTrue(message = "Le numéro de téléphone saisi est invalide")
    */
    public function checktel()
    {
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
      if (in_array($tel[0], ['1', '6', '8']))
        return false;

      $this->setTelephone($tel);
      return true;
    }
}
