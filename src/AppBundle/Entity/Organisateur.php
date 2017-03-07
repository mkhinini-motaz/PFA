<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organisateur
 *
 * @ORM\Table(name="organisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganisateurRepository")
 */
class Organisateur extends Abonne
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
     * @ORM\Column(name="nomSociete", type="string", length=60, nullable=true)
     */
    private $nomSociete;

    /**
     * Relation entre Event et Organisateur
     * @ORM\OneToMany(targetEntity="Eventorganisateur", mappedBy="organisateurs")
     * @ORM\JoinTable(name="eventorganisateur")
     */
    protected $eventorganisateur;

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
     *
     * @return string
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }
}
