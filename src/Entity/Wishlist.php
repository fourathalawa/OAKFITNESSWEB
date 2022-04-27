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

    /**
     * @param int $idwishlist
     * @param int|null $idproduit
     * @param int|null $iduser
     * @param string|null $note
     */


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

    /**
     * @return int|null
     */
    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    /**
     * @param int|null $idproduit
     */
    public function setIdproduit(?int $idproduit): void
    {
        $this->idproduit = $idproduit;
    }

    /**
     * @return int|null
     */
    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    /**
     * @param int|null $iduser
     */
    public function setIduser(?int $iduser): void
    {
        $this->iduser = $iduser;
    }

    /**
     * @return string|null
     */
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
