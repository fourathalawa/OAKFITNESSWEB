<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist")
 * @ORM\Entity
 */
class Wishlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdWishlist", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idwishlist;

    /**
     * @var int|null
     *
     * @ORM\Column(name="IdProduit", type="integer", nullable=true)
     */
    private $idproduit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Note", type="string", length=500, nullable=true)
     */
    private $note;

    public function getIdwishlist(): ?int
    {
        return $this->idwishlist;
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function setIdproduit(?int $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }


}
