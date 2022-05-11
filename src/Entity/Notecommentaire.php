<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notecommentaire
 *
 * @ORM\Table(name="notecommentaire")
 * @ORM\Entity
 */
class Notecommentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="idNote", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnote;

    /**
     * @var int
     *
     * @ORM\Column(name="userID", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="IDCommentaire", type="integer", nullable=false)
     */
    private $idcommentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="isLike", type="integer", nullable=false)
     */
    private $islike;

    /**
     * @return int
     */
    public function getIdnote(): int
    {
        return $this->idnote;
    }

    /**
     * @param int $idnote
     */
    public function setIdnote(int $idnote): void
    {
        $this->idnote = $idnote;
    }

    /**
     * @return int
     */
    public function getUserid(): int
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid(int $userid): void
    {
        $this->userid = $userid;
    }

    /**
     * @return int
     */
    public function getIdcommentaire(): int
    {
        return $this->idcommentaire;
    }

    /**
     * @param int $idcommentaire
     */
    public function setIdcommentaire(int $idcommentaire): void
    {
        $this->idcommentaire = $idcommentaire;
    }

    /**
     * @return int
     */
    public function getIslike(): int
    {
        return $this->islike;
    }

    /**
     * @param int $islike
     */
    public function setIslike(int $islike): void
    {
        $this->islike = $islike;
    }


}
