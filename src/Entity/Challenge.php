<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Challenge
 *
 * @ORM\Table(name="challenge")
 * @ORM\Entity
 */
class Challenge
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdChallenge", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idchallenge;

    /**
     * @var \DateTime
     * @ORM\Column(name="DateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="DateFin",type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var float|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="PoidInt", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidint;

    /**
     * @var float|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="PoidOb", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidob;

    /**
     * @var float|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="Taille", type="float", precision=10, scale=0, nullable=true)
     */
    private $taille;

    /**
     * @var float|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="PoidNv", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidnv;

    /**
     * @var int|null
     * @Assert\NotBlank(message="le champs ne doit pas etre vide")
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;

    public function getIdchallenge(): ?int
    {
        return $this->idchallenge;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getPoidint(): ?float
    {
        return $this->poidint;
    }

    public function setPoidint(?float $poidint): self
    {
        $this->poidint = $poidint;

        return $this;
    }

    public function getPoidob(): ?float
    {
        return $this->poidob;
    }

    public function setPoidob(?float $poidob): self
    {
        $this->poidob = $poidob;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(?float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoidnv(): ?float
    {
        return $this->poidnv;
    }

    public function setPoidnv(?float $poidnv): self
    {
        $this->poidnv = $poidnv;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
