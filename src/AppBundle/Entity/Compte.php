<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compte
 *
 * @ORM\Table(name="compte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompteRepository")
 */
class Compte
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
     * @ORM\Column(name="login", type="string", length=100, unique=true)
     */

    /**
     * Relation entre Compte et l'Abonne propriétaire
     * @ORM\OneToOne(targetEntity="Abonne", mappedBy="compte")
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
     * Set login
     *
     * @param string $login
     *
     * @return Compte
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Compte
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
}
