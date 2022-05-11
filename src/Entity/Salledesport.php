<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salledesport
 *
 * @ORM\Table(name="salledesport")
 * @ORM\Entity
 */
class Salledesport
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Salle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSalle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Adresse", type="string", length=300, nullable=true)
     */
    private $adresse;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Id_responsable", type="integer", nullable=true)
     */
    private $idResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="NomSalle", type="string", length=30, nullable=false)
     */
    private $nomsalle;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixSeance", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixseance;



    public function getIdSalle(): ?int
    {
        return $this->idSalle;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getIdResponsable(): ?int
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?int $idResponsable): self
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }

    public function getNomsalle(): ?string
    {
        return $this->nomsalle;
    }

    public function setNomsalle(string $nomsalle): self
    {
        $this->nomsalle = $nomsalle;

        return $this;
    }

    public function getPrixseance(): ?float
    {
        return $this->prixseance;
    }

    public function setPrixseance(float $prixseance): self
    {
        $this->prixseance = $prixseance;

        return $this;
    }




}
