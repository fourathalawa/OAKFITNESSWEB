<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programmenutritionnel
 *
 * @ORM\Table(name="programmenutritionnel")
 * @ORM\Entity
 */
class Programmenutritionnel
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDProgrammeNutritionnel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprogrammenutritionnel;

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
     * @ORM\Column(name="Calorie", type="integer", nullable=false)
     */
    private $calorie;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeProgrammeNutritionnel", type="string", length=20, nullable=false)
     */
    private $typeprogrammenutritionnel;

    /**
     * @return int
     */
    public function getIdprogrammenutritionnel(): ?int
    {
        return $this->idprogrammenutritionnel;
    }

    /**
     * @param int $idprogrammenutritionnel
     */
    public function setIdprogrammenutritionnel(int $idprogrammenutritionnel): void
    {
        $this->idprogrammenutritionnel = $idprogrammenutritionnel;
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
    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    /**
     * @param int $calorie
     */
    public function setCalorie(int $calorie): void
    {
        $this->calorie = $calorie;
    }

    /**
     * @return string
     */
    public function getTypeprogrammenutritionnel(): ?string
    {
        return $this->typeprogrammenutritionnel;
    }

    /**
     * @param string $typeprogrammenutritionnel
     */
    public function setTypeprogrammenutritionnel(string $typeprogrammenutritionnel): void
    {
        $this->typeprogrammenutritionnel = $typeprogrammenutritionnel;
    }


}
