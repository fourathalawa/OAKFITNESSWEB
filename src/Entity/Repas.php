<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repas
 *
 * @ORM\Table(name="repas")
 * @ORM\Entity
 */
class Repas
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDRepas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrepas;

    /**
     * @var string
     *
     * @ORM\Column(name="PDej", type="string", length=2000, nullable=false)
     */
    private $pdej;

    /**
     * @var string
     *
     * @ORM\Column(name="Dej", type="string", length=2000, nullable=false)
     */
    private $dej;

    /**
     * @var string
     *
     * @ORM\Column(name="Dinn", type="string", length=2000, nullable=false)
     */
    private $dinn;

    /**
     * @var int
     *
     * @ORM\Column(name="Calorie", type="integer", nullable=false)
     */
    private $calorie;

    /**
     * @var string
     *
     * @ORM\Column(name="RestOrActive", type="string", length=20, nullable=false)
     */
    private $restoractive;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @return int
     */
    public function getIdrepas(): ?int
    {
        return $this->idrepas;
    }

    /**
     * @param int $idrepas
     */
    public function setIdrepas(int $idrepas): void
    {
        $this->idrepas = $idrepas;
    }

    /**
     * @return string
     */
    public function getPdej(): ?string
    {
        return $this->pdej;
    }

    /**
     * @param string $pdej
     */
    public function setPdej(string $pdej): void
    {
        $this->pdej = $pdej;
    }

    /**
     * @return string
     */
    public function getDej(): ?string
    {
        return $this->dej;
    }

    /**
     * @param string $dej
     */
    public function setDej(string $dej): void
    {
        $this->dej = $dej;
    }

    /**
     * @return string
     */
    public function getDinn(): ?string
    {
        return $this->dinn;
    }

    /**
     * @param string $dinn
     */
    public function setDinn(string $dinn): void
    {
        $this->dinn = $dinn;
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
    public function getRestoractive(): ?string
    {
        return $this->restoractive;
    }

    /**
     * @param string $restoractive
     */
    public function setRestoractive(string $restoractive): void
    {
        $this->restoractive = $restoractive;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }


}
