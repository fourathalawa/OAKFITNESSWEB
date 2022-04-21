<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdReservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateReservation", type="date", nullable=false)
     */
    private $datereservation;

    /**
     * @var int
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="NomSalle", type="string", length=500, nullable=false)
     */
    private $nomsalle;

    /**
     * @var bool
     *
     * @ORM\Column(name="AccCoach", type="boolean", nullable=false)
     */
    private $acccoach;

    /**
     * @var bool
     *
     * @ORM\Column(name="AccResponsable", type="boolean", nullable=false)
     */
    private $accresponsable;

    public function getIdreservation(): ?int
    {
        return $this->idreservation;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->datereservation;
    }

    public function setDatereservation(\DateTimeInterface $datereservation): self
    {
        $this->datereservation = $datereservation;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

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

    public function getAcccoach(): ?bool
    {
        return $this->acccoach;
    }

    public function setAcccoach(bool $acccoach): self
    {
        $this->acccoach = $acccoach;

        return $this;
    }

    public function getAccresponsable(): ?bool
    {
        return $this->accresponsable;
    }

    public function setAccresponsable(bool $accresponsable): self
    {
        $this->accresponsable = $accresponsable;

        return $this;
    }


}
