<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
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
     * @Assert\NotNull
     * @ORM\Column(name="IDCreatorEvenement", type="string", length=100, nullable=false)
     */
    private $idcreatorevenement;

    /**
     * @var \DateTime|null
     * @Assert\NotNull
     * @ORM\Column(name="DateEvenement", type="date", nullable=true)
     */
    private $dateevenement;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 7,
     *      max = 25,
     *      minMessage = "Event title must be at least  7  characters long",
     *      maxMessage = "Event title cannot be longer than  25  characters"
     * )
     * @ORM\Column(name="TitreEvenement", type="string", length=50, nullable=false)
     */
    private $titreevenement;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 7,
     *      max = 200,
     *      minMessage = "Event Description must be at least  25  characters long",
     *      maxMessage = "Event Description cannot be longer than  200  characters"
     * )
     * @ORM\Column(name="DescrEvenement", type="string", length=200, nullable=false)
     */
    private $descrevenement;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 7,
     *      max = 25,
     *      minMessage = "Event Address must be at least  10  characters long",
     *      maxMessage = "Event Address cannot be longer than  30  characters"
     * )
     * @ORM\Column(name="AdresseEvenement", type="string", length=30, nullable=false)
     */
    private $adresseevenement;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="TypeEvenement", type="string", length=20, nullable=false)
     */
    private $typeevenement;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg","image/png"})
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
