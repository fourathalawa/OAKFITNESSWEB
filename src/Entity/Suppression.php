<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suppression
 *
 * @ORM\Table(name="suppression")
 * @ORM\Entity
 */
class Suppression
{
    /**
     * @var int
     *
     * @ORM\Column(name="idS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ids;

    /**
     * @var int
     *
     * @ORM\Column(name="idUserS", type="integer", nullable=false)
     */
    private $idusers;

    /**
     * @return int
     */
    public function getIds(): int
    {
        return $this->ids;
    }

    /**
     * @param int $ids
     */
    public function setIds(int $ids): void
    {
        $this->ids = $ids;
    }

    /**
     * @return int
     */
    public function getIdusers(): int
    {
        return $this->idusers;
    }

    /**
     * @param int $idusers
     */
    public function setIdusers(int $idusers): void
    {
        $this->idusers = $idusers;
    }


}
