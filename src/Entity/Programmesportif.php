<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programmesportif
 *
 * @ORM\Table(name="programmesportif")
 * @ORM\Entity
 */
class Programmesportif
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDProgrammeSportif", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprogrammesportif;

    /**
     * @var string
     *
     * @ORM\Column(name="IDCoach", type="string", length=100, nullable=false)
     */
    private $idcoach;

    /**
     * @var string
     *
     * @ORM\Column(name="IDAdherent", type="string", length=100, nullable=false)
     */
    private $idadherent;

    /**
     * @var int
     *
     * @ORM\Column(name="DureeMois", type="integer", nullable=false)
     */
    private $dureemois;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeProgrammeSportif", type="string", length=20, nullable=false)
     */
    private $typeprogrammesportif;

    /**
     * @return int
     */
    public function getIdprogrammesportif(): ?int
    {
        return $this->idprogrammesportif;
    }

    /**
     * @param int $idprogrammesportif
     */
    public function setIdprogrammesportif(int $idprogrammesportif): void
    {
        $this->idprogrammesportif = $idprogrammesportif;
    }

    /**
     * @return string
     */
    public function getIdcoach(): ?string
    {
        return $this->idcoach;
    }

    /**
     * @param string $idcoach
     */
    public function setIdcoach(string $idcoach): void
    {
        $this->idcoach = $idcoach;
    }

    /**
     * @return string
     */
    public function getIdadherent(): ?string
    {
        return $this->idadherent;
    }

    /**
     * @param string $idadherent
     */
    public function setIdadherent(string $idadherent): void
    {
        $this->idadherent = $idadherent;
    }

    /**
     * @return int
     */
    public function getDureemois(): ?int
    {
        return $this->dureemois;
    }

    /**
     * @param int $dureemois
     */
    public function setDureemois(int $dureemois): void
    {
        $this->dureemois = $dureemois;
    }

    /**
     * @return string
     */
    public function getTypeprogrammesportif(): ?string
    {
        return $this->typeprogrammesportif;
    }

    /**
     * @param string $typeprogrammesportif
     */
    public function setTypeprogrammesportif(string $typeprogrammesportif): void
    {
        $this->typeprogrammesportif = $typeprogrammesportif;
    }


}
