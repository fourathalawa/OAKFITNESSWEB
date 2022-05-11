<?php

namespace App\Entity;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="NomUser", type="string", length=50, nullable=false)
     */
    private $nomuser;

    /**
     * @var string
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="PrenomUser", type="string", length=50, nullable=false)
     */
    private $prenomuser;

    /**
     * @var string
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="MailUser", type="string", length=60, nullable=false)
     */
    private $mailuser;

    /**
     * @var int
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="TelephoneNumberUser", type="bigint", nullable=false)
     */
    private $telephonenumberuser;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="DateNaissanceUser", type="date", nullable=false)
     */
    private $datenaissanceuser;

    /**
     * @var int
     *
     * @ORM\Column(name="RoleUser", type="integer", nullable=false)
     */
    private $roleuser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="NumeroPackUser", type="integer", nullable=true)
     */
    private $numeropackuser;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateCommence", type="date", nullable=true)
     */
    private $datecommence;

    /**
     * @var string|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="ExperienceUser", type="string", length=150, nullable=true)
     */
    private $experienceuser;

    /**
     * @var string|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="DiplomeUser", type="string", length=150, nullable=true)
     */
    private $diplomeuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="AdresseSalleSport", type="string", length=150, nullable=true)
     */
    private $adressesallesport;

    /**
     * @var int|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="MatriculeFiscale", type="bigint", nullable=true)
     */
    private $matriculefiscale;

    /**
     * @var string|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="Password", type="string", length=45, nullable=true)
     */
    private $password;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CodeVerification", type="integer", nullable=true)
     */
    private $codeverification;

    /**
     * @var string|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="imageUser", type="string", nullable=false)
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $imageuser;



    public function __construct()
    {
        $this->salles = new ArrayCollection();
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    public function getPrenomuser(): ?string
    {
        return $this->prenomuser;
    }

    public function setPrenomuser(string $prenomuser): self
    {
        $this->prenomuser = $prenomuser;

        return $this;
    }

    public function getMailuser(): ?string
    {
        return $this->mailuser;
    }

    public function setMailuser(string $mailuser): self
    {
        $this->mailuser = $mailuser;

        return $this;
    }

    public function getTelephonenumberuser(): ?string
    {
        return $this->telephonenumberuser;
    }

    public function setTelephonenumberuser(string $telephonenumberuser): self
    {
        $this->telephonenumberuser = $telephonenumberuser;

        return $this;
    }

    public function getDatenaissanceuser(): ?\DateTimeInterface
    {
        return $this->datenaissanceuser;
    }

    public function setDatenaissanceuser(\DateTimeInterface $datenaissanceuser): self
    {
        $this->datenaissanceuser = $datenaissanceuser;

        return $this;
    }

    public function getRoleuser(): ?int
    {
        return $this->roleuser;
    }

    public function setRoleuser(int $roleuser): self
    {
        $this->roleuser = $roleuser;

        return $this;
    }

    public function getNumeropackuser(): ?int
    {
        return $this->numeropackuser;
    }

    public function setNumeropackuser(?int $numeropackuser): self
    {
        $this->numeropackuser = $numeropackuser;

        return $this;
    }

    public function getDatecommence(): ?\DateTimeInterface
    {
        return $this->datecommence;
    }

    public function setDatecommence(?\DateTimeInterface $datecommence): self
    {
        $this->datecommence = $datecommence;

        return $this;
    }

    public function getExperienceuser(): ?string
    {
        return $this->experienceuser;
    }

    public function setExperienceuser(?string $experienceuser): self
    {
        $this->experienceuser = $experienceuser;

        return $this;
    }

    public function getDiplomeuser(): ?string
    {
        return $this->diplomeuser;
    }

    public function setDiplomeuser(?string $diplomeuser): self
    {
        $this->diplomeuser = $diplomeuser;

        return $this;
    }

    public function getAdressesallesport(): ?string
    {
        return $this->adressesallesport;
    }

    public function setAdressesallesport(?string $adressesallesport): self
    {
        $this->adressesallesport = $adressesallesport;

        return $this;
    }

    public function getMatriculefiscale(): ?string
    {
        return $this->matriculefiscale;
    }

    public function setMatriculefiscale(?string $matriculefiscale): self
    {
        $this->matriculefiscale = $matriculefiscale;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCodeverification(): ?int
    {
        return $this->codeverification;
    }

    public function setCodeverification(?int $codeverification): self
    {
        $this->codeverification = $codeverification;

        return $this;
    }

    public function getImageuser(): ?string
    {
        return $this->imageuser;
    }

    public function setImageuser(?string $imageuser) : self
    {
        $this->imageuser = $imageuser;

        return $this;
    }

    public function User(string $nom,string $prenom ,string $mailuser,string $date,string $password): self
    {
        $this->nomuser = $nom;
        $this->prenomuser = $prenom;
        $this->mailuser = $mailuser;
        $this->datenaissanceuser = $date;
        $this->password= $password;

        return $this;
    }
    public function UserC(string $nom,string $prenom ,string $mailuser,string $date,string $experienceuser,string $diplomeuser,string $password): self
    {
        $this->nomuser = $nom;
        $this->prenomuser = $prenom;
        $this->mailuser = $mailuser;
        $this->datenaissanceuser = $date;
        $this->experienceuser = $experienceuser;
        $this->diplomeuser = $diplomeuser;
        $this->password= $password;

        return $this;
    }



}