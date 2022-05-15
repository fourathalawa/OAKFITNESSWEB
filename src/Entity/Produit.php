<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("produit")
     */
    private $idproduit;

    /**
     * @var string
     *@Assert\NotNull
     * @ORM\Column(name="NomProduit", type="string", length=255, nullable=false)
     * @Groups("produit")
     */
    private $nomproduit;

    /**
     * @var string
     *@Assert\NotNull
     * @ORM\Column(name="CategProduit", type="string", length=255, nullable=false)
     * @Groups("produit")
     */
    private $categproduit;

    /**
     * @var string
     * @Assert\Length(
     *      min = 7,
     *      max = 25,
     *      minMessage = "Your descreption must be at least  7  characters long",
     *      maxMessage = "Your descreption cannot be longer than  25  characters"
     * )
     * @ORM\Column(name="DescrProduit", type="string", length=255, nullable=false)
     * @Groups("produit")
     */
    private $descrproduit;

    /**
     * @var float
     * @Assert\Type(
     *     type="float",
     *     message="The value  value  is not a valid  type ."
     * )
     *@Assert\Positive
     * @ORM\Column(name="PrixProduit", type="float", precision=10, scale=0, nullable=false)
     * @Groups("produit")
     */
    private $prixproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="IsAvailable", type="integer", nullable=false)
     * @Groups("produit")
     */
    private $isavailable;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg","image/png"})
     * @ORM\Column(name="ImageProduit", type="string", length=255, nullable=false)
     * @Groups("produit")
     */
    private $imageproduit;

    /**
     * @var int
     **  @Assert\Type(
     *     type="int",
     *     message="The value is not a valid  type ."
     * )
     *@Assert\Positive
     * @ORM\Column(name="StockProduit", type="integer", nullable=false)
     * @Groups("produit")
     */
    private $stockproduit;

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getNomproduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomproduit(string $nomproduit): self
    {
        $this->nomproduit = $nomproduit;

        return $this;
    }

    public function getCategproduit(): ?string
    {
        return $this->categproduit;
    }

    public function setCategproduit(string $categproduit): self
    {
        $this->categproduit = $categproduit;

        return $this;
    }

    public function getDescrproduit(): ?string
    {
        return $this->descrproduit;
    }

    public function setDescrproduit(string $descrproduit): self
    {
        $this->descrproduit = $descrproduit;

        return $this;
    }

    public function getPrixproduit(): ?float
    {
        return $this->prixproduit;
    }

    public function setPrixproduit(float $prixproduit): self
    {
        $this->prixproduit = $prixproduit;

        return $this;
    }

    public function getIsavailable(): ?int
    {
        return $this->isavailable;
    }

    public function setIsavailable(int $isavailable): self
    {
        $this->isavailable = $isavailable;

        return $this;
    }

    public function getImageproduit()
    {
        return $this->imageproduit;
    }

    public function setImageproduit( $imageproduit):self
    {
        $this->imageproduit = $imageproduit;

        return $this;
    }

    public function getStockproduit(): ?int
    {
        return $this->stockproduit;
    }

    public function setStockproduit(int $stockproduit): self
    {
        $this->stockproduit = $stockproduit;

        return $this;
    }
    public function __toString(){
        return (string)$this->idproduit;
    }

}