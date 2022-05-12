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
     * @ORM\Column(type='integer')
     */
    private $idproduit;

    /**
    * @ORM\Column(type='integer')
     */
    private $iduser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Note", type="string", length=500, nullable=true)
     */
    private $note;


    /**
     * @return int
     */
    public function getIdwishlist(): int
    {
        return $this->idwishlist;
    }

    /**
     * @param int $idwishlist
     */
    public function setIdwishlist(int $idwishlist): void
    {
        $this->idwishlist = $idwishlist;
    }


    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }


    public function setIdproduit(int $idproduit): self
    {
        $this->idproduit = $idproduit;
        return $this;
    }


    public function getIduser() :?int
    {
        return $this->iduser;
    }


    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;
        return $this;

    }


    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
    }




}
