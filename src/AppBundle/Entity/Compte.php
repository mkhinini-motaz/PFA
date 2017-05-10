<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompteRepository")
 * @ORM\Table(name="compte")
 */
class Compte extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date_inscription", type="date", nullable=true)
     */
    protected $dateInscription;

    /**
     * Relation entre Abonne et son Compte
     * @ORM\OneToOne(targetEntity="Abonne", mappedBy="compte")
     * @ORM\JoinColumn(name="abonne_id", referencedColumnName="id")
     */
    private $abonne;


    public function __construct()
    {
        parent::__construct();

    }

    /**
    * Set abonne
    *
    * @param \AppBundle\Entity\Abonne $abonne
    *
    * @return Compte
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

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return Compte
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }
}
