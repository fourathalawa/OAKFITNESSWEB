<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDEvenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="IDCreatorEvenement", type="string", length=100, nullable=false)
     */
    private $idcreatorevenement;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateEvenement", type="date", nullable=true)
     */
    private $dateevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreEvenement", type="string", length=50, nullable=false)
     */
    private $titreevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="DescrEvenement", type="string", length=200, nullable=false)
     */
    private $descrevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseEvenement", type="string", length=30, nullable=false)
     */
    private $adresseevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeEvenement", type="string", length=20, nullable=false)
     */
    private $typeevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @return int
     */
    public function getIdevenement(): ?int
    {
        return $this->idevenement;
    }

    /**
     * @param int $idevenement
     */
    public function setIdevenement(int $idevenement): void
    {
        $this->idevenement = $idevenement;
    }

    /**
     * @return string
     */
    public function getIdcreatorevenement(): ?string
    {
        return $this->idcreatorevenement;
    }

    /**
     * @param string $idcreatorevenement
     */
    public function setIdcreatorevenement(string $idcreatorevenement): void
    {
        $this->idcreatorevenement = $idcreatorevenement;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateevenement(): ?\DateTime
    {
        return $this->dateevenement;
    }

    /**
     * @param \DateTime|null $dateevenement
     */
    public function setDateevenement(?\DateTime $dateevenement): void
    {
        $this->dateevenement = $dateevenement;
    }

    /**
     * @return string
     */
    public function getTitreevenement(): ?string
    {
        return $this->titreevenement;
    }

    /**
     * @param string $titreevenement
     */
    public function setTitreevenement(string $titreevenement): void
    {
        $this->titreevenement = $titreevenement;
    }

    /**
     * @return string
     */
    public function getDescrevenement(): ?string
    {
        return $this->descrevenement;
    }

    /**
     * @param string $descrevenement
     */
    public function setDescrevenement(string $descrevenement): void
    {
        $this->descrevenement = $descrevenement;
    }

    /**
     * @return string
     */
    public function getAdresseevenement(): ?string
    {
        return $this->adresseevenement;
    }

    /**
     * @param string $adresseevenement
     */
    public function setAdresseevenement(string $adresseevenement): void
    {
        $this->adresseevenement = $adresseevenement;
    }

    /**
     * @return string
     */
    public function getTypeevenement(): ?string
    {
        return $this->typeevenement;
    }

    /**
     * @param string $typeevenement
     */
    public function setTypeevenement(string $typeevenement): void
    {
        $this->typeevenement = $typeevenement;
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
