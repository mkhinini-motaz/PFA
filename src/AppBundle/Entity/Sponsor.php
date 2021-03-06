<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SponsorRepository")
 */
class Sponsor
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
     * @ORM\Column(name="nom", type="string", length=40)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=40, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=70, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=150, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=50, nullable=true)
     */
    private $logo;

    /**
     * Relation entre Event et Sponsor
     * @ORM\OneToMany(targetEntity="Sponsoring", mappedBy="sponsor")
     * @ORM\JoinTable(name="sponsoring")
     */
    protected $sponsoring;

    public function __construct() {
        $this->sponsoring = new ArrayCollection();

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
     * @return Sponsor
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Sponsor
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Sponsor
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Sponsor
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Sponsor
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Sponsor
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Sponsor
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
     * Add sponsoring
     *
     * @param \AppBundle\Entity\Sponsoring $sponsoring
     *
     * @return Sponsor
     */
    public function addSponsoring(\AppBundle\Entity\Sponsoring $sponsoring)
    {
        $this->sponsoring[] = $sponsoring;

        return $this;
    }

    /**
     * Remove sponsoring
     *
     * @param \AppBundle\Entity\Sponsoring $sponsoring
     */
    public function removeSponsoring(\AppBundle\Entity\Sponsoring $sponsoring)
    {
        $this->sponsoring->removeElement($sponsoring);
    }

    /**
     * Get sponsoring
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSponsoring()
    {
        return $this->sponsoring;
    }

    /**
     * Set sponsoring
     *
     * @param string $sponsoring
     *
     * @return Sponsor
     */
    public function setSponsoring($sponsoring)
    {
        $this->sponsoring = $sponsoring;

        return $this;
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

}
