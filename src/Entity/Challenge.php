<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="DateDebut", type="string", length=20, nullable=false)
     */
    private $datedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="DateFin", type="string", length=20, nullable=false)
     */
    private $datefin;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PoidInt", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidint;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PoidOb", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidob;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Taille", type="float", precision=10, scale=0, nullable=true)
     */
    private $taille;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PoidNv", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidnv;

    /**
     * @var int|null
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;

    public function getIdchallenge(): ?int
    {
        return $this->idchallenge;
    }

    public function getDatedebut(): ?string
    {
        return $this->datedebut;
    }

    public function setDatedebut(string $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?string
    {
        return $this->datefin;
    }

    public function setDatefin(string $datefin): self
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
