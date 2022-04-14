<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDpublication", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpublication;

    /**
     * @var int
     *
     * @ORM\Column(name="IDuser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="DatePublication", type="string", length=255, nullable=false)
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Publication", type="string", length=255, nullable=false)
     */
    private $publication;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="publication",cascade={"all"},orphanRemoval=true )
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getIdpublication(): ?int
    {
        return $this->idpublication;
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

    public function getDatepublication(): ?string
    {
        return $this->datepublication;
    }

    public function setDatepublication(string $datepublication): self
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    public function getPublication(): ?string
    {
        return $this->publication;
    }

    public function setPublication(string $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPublication($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPublication() === $this) {
                $commentaire->setPublication(null);
            }
        }

        return $this;
    }


}
