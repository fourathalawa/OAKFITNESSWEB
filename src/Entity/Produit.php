<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="NomProduit", type="string", length=255, nullable=false)
     */
    private $nomproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="CategProduit", type="string", length=255, nullable=false)
     */
    private $categproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="DescrProduit", type="string", length=255, nullable=false)
     */
    private $descrproduit;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixProduit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="IsAvailable", type="integer", nullable=false)
     */
    private $isavailable;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageProduit", type="string", length=255, nullable=false)
     */
    private $imageproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="StockProduit", type="integer", nullable=false)
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

    public function getImageproduit(): ?string
    {
        return $this->imageproduit;
    }

    public function setImageproduit(string $imageproduit): self
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


}
