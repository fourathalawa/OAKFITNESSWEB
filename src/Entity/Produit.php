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


}
