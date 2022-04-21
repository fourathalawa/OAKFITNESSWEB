<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transformation
 *
 * @ORM\Table(name="transformation")
 * @ORM\Entity
 */
class Transformation
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdImage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idimage;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreImage", type="string", length=255, nullable=false)
     */
    private $titreimage;

    /**
     * @var string
     *
     * @ORM\Column(name="DescreptionImage", type="string", length=255, nullable=false)
     */
    private $descreptionimage;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageAvant", type="string", length=255, nullable=false)
     */
    private $imageavant;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageApres", type="string", length=255, nullable=false)
     */
    private $imageapres;

    /**
     * @var int
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var float
     *
     * @ORM\Column(name="PoidAvant", type="float", precision=10, scale=0, nullable=false)
     */
    private $poidavant;

    /**
     * @var float
     *
     * @ORM\Column(name="PoidApres", type="float", precision=10, scale=0, nullable=false)
     */
    private $poidapres;

    /**
     * @var float
     *
     * @ORM\Column(name="TailleAvant", type="float", precision=10, scale=0, nullable=false)
     */
    private $tailleavant;

    /**
     * @var float
     *
     * @ORM\Column(name="TailleApres", type="float", precision=10, scale=0, nullable=false)
     */
    private $tailleapres;

    /**
     * @var int
     *
     * @ORM\Column(name="Tlike", type="integer", nullable=false)
     */
    private $tlike;

    public function getIdimage(): ?int
    {
        return $this->idimage;
    }

    public function getTitreimage(): ?string
    {
        return $this->titreimage;
    }

    public function setTitreimage(string $titreimage): self
    {
        $this->titreimage = $titreimage;

        return $this;
    }

    public function getDescreptionimage(): ?string
    {
        return $this->descreptionimage;
    }

    public function setDescreptionimage(string $descreptionimage): self
    {
        $this->descreptionimage = $descreptionimage;

        return $this;
    }

    public function getImageavant(): ?string
    {
        return $this->imageavant;
    }

    public function setImageavant(string $imageavant): self
    {
        $this->imageavant = $imageavant;

        return $this;
    }

    public function getImageapres(): ?string
    {
        return $this->imageapres;
    }

    public function setImageapres(string $imageapres): self
    {
        $this->imageapres = $imageapres;

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

    public function getPoidavant(): ?float
    {
        return $this->poidavant;
    }

    public function setPoidavant(float $poidavant): self
    {
        $this->poidavant = $poidavant;

        return $this;
    }

    public function getPoidapres(): ?float
    {
        return $this->poidapres;
    }

    public function setPoidapres(float $poidapres): self
    {
        $this->poidapres = $poidapres;

        return $this;
    }

    public function getTailleavant(): ?float
    {
        return $this->tailleavant;
    }

    public function setTailleavant(float $tailleavant): self
    {
        $this->tailleavant = $tailleavant;

        return $this;
    }

    public function getTailleapres(): ?float
    {
        return $this->tailleapres;
    }

    public function setTailleapres(float $tailleapres): self
    {
        $this->tailleapres = $tailleapres;

        return $this;
    }

    public function getTlike(): ?int
    {
        return $this->tlike;
    }

    public function setTlike(int $tlike): self
    {
        $this->tlike = $tlike;

        return $this;
    }


}
