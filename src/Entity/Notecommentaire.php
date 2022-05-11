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

    public function getIdnote(): ?int
    {
        return $this->idnote;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getIdcommentaire(): ?int
    {
        return $this->idcommentaire;
    }

    public function setIdcommentaire(int $idcommentaire): self
    {
        $this->idcommentaire = $idcommentaire;

        return $this;
    }

    public function getIslike(): ?int
    {
        return $this->islike;
    }

    public function setIslike(int $islike): self
    {
        $this->islike = $islike;

        return $this;
    }


}
