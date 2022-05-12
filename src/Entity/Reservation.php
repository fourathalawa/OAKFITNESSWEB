<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @var \User
     *
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="IdUser")
     * })
     */
    private $iduser;

    /**
     * @var string
     * @Assert\NotBlank()
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

    /**
     * @return int
     */
    public function getIdreservation(): int
    {
        return $this->idreservation;
    }

    /**
     * @param int $idreservation
     */
    public function setIdreservation(int $idreservation): void
    {
        $this->idreservation = $idreservation;
    }

    /**
     * @return \DateTime
     */
    public function getDatereservation(): ?\DateTime
    {
        return $this->datereservation;
    }

    /**
     * @param \DateTime $datereservation
     */
    public function setDatereservation(\DateTime $datereservation): void
    {
        $this->datereservation = $datereservation;
    }

    /**
     * @return User
     */
    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    /**
     * @param User $iduser
     */
    public function setIduser(User $iduser): void
    {
        $this->iduser = $iduser;
    }

    /**
     * @return string
     */
    public function getNomsalle(): ?string
    {
        return $this->nomsalle;
    }

    /**
     * @param string $nomsalle
     */
    public function setNomsalle(string $nomsalle): void
    {
        $this->nomsalle = $nomsalle;
    }

    /**
     * @return bool
     */
    public function isAcccoach(): ?bool
    {
        return $this->acccoach;
    }

    /**
     * @param bool $acccoach
     */
    public function setAcccoach(bool $acccoach): void
    {
        $this->acccoach = $acccoach;
    }

    /**
     * @return bool
     */
    public function isAccresponsable(): ?bool
    {
        return $this->accresponsable;
    }

    /**
     * @param bool $accresponsable
     */
    public function setAccresponsable(bool $accresponsable): void
    {
        $this->accresponsable = $accresponsable;
    }


}
