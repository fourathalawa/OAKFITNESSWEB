<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Exercice
 *
 * @ORM\Table(name="exercice")
 * @ORM\Entity(repositoryClass="App\Repository\ExerciceRepository")
 */
class Exercice
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDExercice", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */

    private $idexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Exercice type must be at least  7  characters long",
     *      maxMessage = "Exercice type cannot be longer than  25  characters"
     * )
     * @ORM\Column(name="TypeExercice", type="string", length=20, nullable=false)
     */
    private $typeexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 7,
     *      max = 25,
     *      minMessage = "Exercice name must be at least  7  characters long",
     *      maxMessage = "Exercice name cannot be longer than  25  characters"
     * )
     * @ORM\Column(name="NomExercice", type="string", length=50, nullable=false)
     */
    private $nomexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="Muscle", type="string", length=70, nullable=false)
     */
    private $muscle;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @ORM\Column(name="video", type="string", length=50, nullable=false)
     */
    private $video;

    /**
     * @var string
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 7,
     *      max = 250,
     *      minMessage = "Your descreption must be at least  25  characters long",
     *      maxMessage = "Your video cannot be longer than  250  characters"
     * )
     * @ORM\Column(name="DescrExercice", type="string", length=2000, nullable=false)
     */
    private $descrexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="DiffExercice", type="string", length=20, nullable=false)
     */
    private $diffexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="JusteSalleExercice", type="string", length=20, nullable=false)
     */
    private $justesalleexercice;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="DureeExercice", type="string", length=30, nullable=false)
     */
    private $dureeexercice;

    /**
     * @ORM\Column(name="Image",type="string", length=255)
     * @Assert\File(mimeTypes={"image/jpeg","image/png"})
     */
    private $image;

    /**
     * @return int
     */
    public function getIdexercice(): ?int
    {
        return $this->idexercice;
    }

    /**
     * @param int $idexercice
     */
    public function setIdexercice(int $idexercice): void
    {
        $this->idexercice = $idexercice;
    }

    /**
     * @return string
     */
    public function getTypeexercice(): ?string
    {
        return $this->typeexercice;
    }

    /**
     * @param string $typeexercice
     */
    public function setTypeexercice(string $typeexercice): void
    {
        $this->typeexercice = $typeexercice;
    }

    /**
     * @return string
     */
    public function getNomexercice(): ?string
    {
        return $this->nomexercice;
    }

    /**
     * @param string $nomexercice
     */
    public function setNomexercice(string $nomexercice): void
    {
        $this->nomexercice = $nomexercice;
    }

    /**
     * @return string
     */
    public function getMuscle(): ?string
    {
        return $this->muscle;
    }

    /**
     * @param string $muscle
     */
    public function setMuscle(string $muscle): void
    {
        $this->muscle = $muscle;
    }

    /**
     * @return string
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo(string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getDescrexercice(): ?string
    {
        return $this->descrexercice;
    }

    /**
     * @param string $descrexercice
     */
    public function setDescrexercice(string $descrexercice): void
    {
        $this->descrexercice = $descrexercice;
    }

    /**
     * @return string
     */
    public function getDiffexercice(): ?string
    {
        return $this->diffexercice;
    }

    /**
     * @param string $diffexercice
     */
    public function setDiffexercice(string $diffexercice): void
    {
        $this->diffexercice = $diffexercice;
    }

    /**
     * @return string
     */
    public function getJustesalleexercice(): ?string
    {
        return $this->justesalleexercice;
    }

    /**
     * @param string $justesalleexercice
     */
    public function setJustesalleexercice(string $justesalleexercice): void
    {
        $this->justesalleexercice = $justesalleexercice;
    }

    /**
     * @return string
     */
    public function getDureeexercice(): ?string
    {
        return $this->dureeexercice;
    }

    /**
     * @param string $dureeexercice
     */
    public function setDureeexercice(string $dureeexercice): void
    {
        $this->dureeexercice = $dureeexercice;
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