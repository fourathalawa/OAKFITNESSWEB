<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDCommentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcommentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="IDPublication", type="integer", nullable=false)
     */
    private $idpublication;

    /**
     * @var int
     *
     * @ORM\Column(name="IDUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=500, nullable=false)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="DateCommentaire", type="string", length=255, nullable=false)
     */
    private $datecommentaire;

    /**
     * @var int|null
     *
     * @ORM\Column(name="publication_id", type="integer", nullable=true)
     */
    private $publicationId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbLikes", type="integer", nullable=true)
     */
    private $nblikes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Usernamep", type="string", length=250, nullable=true)
     */
    private $usernamep;

    public function getId(): ?int
    {
        return $this->idcommentaire;
    }

    public function getIdpublication(): ?int
    {
        return $this->idpublication;
    }

    public function setIdpublication(int $idpublication): self
    {
        $this->idpublication = $idpublication;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDatecommentaire(): ?string
    {
        return $this->datecommentaire;
    }

    public function setDatecommentaire(string $datecommentaire): self
    {
        $this->datecommentaire = $datecommentaire;

        return $this;
    }

    public function getPublicationId(): ?int
    {
        return $this->publicationId;
    }

    public function setPublicationId(?int $publicationId): self
    {
        $this->publicationId = $publicationId;

        return $this;
    }

    public function getNblikes(): ?int
    {
        return $this->nblikes;
    }

    public function setNblikes(?int $nblikes): self
    {
        $this->nblikes = $nblikes;

        return $this;
    }

    public function getUsernamep(): ?string
    {
        return $this->usernamep;
    }

    public function setUsernamep(?string $usernamep): self
    {
        $this->usernamep = $usernamep;

        return $this;
    }


}
