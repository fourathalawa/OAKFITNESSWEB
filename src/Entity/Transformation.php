<?php

namespace App\Entity;
use App\Repository\TransformationRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Transformation
 *
 * @ORM\Table(name="transformation")
 * @ORM\Entity(repositoryClass=TransformationRepository::class)
 *
 * 
 */
class Transformation
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdImage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *  @Groups("transformation")
     */
    private $idimage;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="TitreImage", type="string", length=255, nullable=false)
     *  @Groups("transformation")
     */
    private $titreimage;

    /**
     * @var string
     *
     * @ORM\Column(name="DescreptionImage", type="string", length=255, nullable=false)
     *
     * @Assert\Length(
     *      min = 7,
     *      max = 25,
     *      minMessage = "Your descreption must be at least  7  characters long",
     *      maxMessage = "Your descreption cannot be longer than  25  characters"
     * )
     *  @Groups("transformation")
     */
    private $descreptionimage;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="ImageAvant", type="string", length=255, nullable=false)
     *  @Groups("transformation")
     */
    private $imageavant;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="ImageApres", type="string", length=255, nullable=false)
     *  @Groups("transformation")
     */
    private $imageapres;

    /**
     * @var int
     * @Assert\NotNull
     * @ORM\Column(name="IdUser", type="integer", nullable=false)
     *  @Groups("transformation")
     */
    private $iduser;

    /**
     * @var float
     *  @Assert\Type(
     *     type="float",
     *     message="The value  is not a valid  type ."
     * )
     *@Assert\Positive
     * @ORM\Column(name="PoidAvant", type="float", precision=10, scale=0, nullable=false)
     *  @Groups("transformation")
     */
    private $poidavant;

    /**
     * @var float
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *@Assert\Positive
     * @ORM\Column(name="PoidApres", type="float", precision=10, scale=0, nullable=false)
     *  @Groups("transformation")
     */
    private $poidapres;

    /**
     * @var float
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *  @Assert\Positive
     * @ORM\Column(name="TailleAvant", type="float", precision=10, scale=0, nullable=false)
     *  @Groups("transformation")
     */
    private $tailleavant;

    /**
     * @var float
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Positive
     * @ORM\Column(name="TailleApres", type="float", precision=10, scale=0, nullable=false)
     *  @Groups("transformation")
     */
    private $tailleapres;

    /**
     * @var int
     *
     * @ORM\Column(name="Tlike", type="integer", nullable=false)
     *  @Groups("transformation")
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

    public function getImageavant()
    {
        return $this->imageavant;
    }

    public function setImageavant( $imageavant)
    {
        $this->imageavant = $imageavant;

        return $this;
    }

    public function getImageapres()
    {
        return $this->imageapres;
    }

    public function setImageapres( $imageapres)
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
