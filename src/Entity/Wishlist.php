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


}
