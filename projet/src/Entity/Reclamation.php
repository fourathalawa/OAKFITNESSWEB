<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDReclamation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreclamation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="IDUserReclamation", type="integer", nullable=true)
     */
    private $iduserreclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="DescrReclam", type="string", length=500, nullable=false)
     */
    private $descrreclam;

    /**
     * @var int
     *
     * @ORM\Column(name="CategReclam", type="integer", nullable=false)
     */
    private $categreclam;

    /**
     * @var string
     *
     * @ORM\Column(name="DateReclam", type="string", length=255, nullable=false)
     */
    private $datereclam;

    /**
     * @var string
     *
     * @ORM\Column(name="EtatReclamation", type="string", length=100, nullable=false)
     */
    private $etatreclamation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CommentaireRec", type="string", length=255, nullable=true)
     */
    private $commentairerec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PubRec", type="string", length=255, nullable=true)
     */
    private $pubrec;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idCommentReclam", type="integer", nullable=true)
     */
    private $idcommentreclam;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idReclameur", type="integer", nullable=true)
     */
    private $idreclameur;

    public function getIdreclamation(): ?int
    {
        return $this->idreclamation;
    }

    public function getIduserreclamation(): ?int
    {
        return $this->iduserreclamation;
    }

    public function setIduserreclamation(?int $iduserreclamation): self
    {
        $this->iduserreclamation = $iduserreclamation;

        return $this;
    }

    public function getDescrreclam(): ?string
    {
        return $this->descrreclam;
    }

    public function setDescrreclam(string $descrreclam): self
    {
        $this->descrreclam = $descrreclam;

        return $this;
    }

    public function getCategreclam(): ?int
    {
        return $this->categreclam;
    }

    public function setCategreclam(int $categreclam): self
    {
        $this->categreclam = $categreclam;

        return $this;
    }

    public function getDatereclam(): ?string
    {
        return $this->datereclam;
    }

    public function setDatereclam(string $datereclam): self
    {
        $this->datereclam = $datereclam;

        return $this;
    }

    public function getEtatreclamation(): ?string
    {
        return $this->etatreclamation;
    }

    public function setEtatreclamation(string $etatreclamation): self
    {
        $this->etatreclamation = $etatreclamation;

        return $this;
    }

    public function getCommentairerec(): ?string
    {
        return $this->commentairerec;
    }

    public function setCommentairerec(?string $commentairerec): self
    {
        $this->commentairerec = $commentairerec;

        return $this;
    }

    public function getPubrec(): ?string
    {
        return $this->pubrec;
    }

    public function setPubrec(?string $pubrec): self
    {
        $this->pubrec = $pubrec;

        return $this;
    }

    public function getIdcommentreclam(): ?int
    {
        return $this->idcommentreclam;
    }

    public function setIdcommentreclam(?int $idcommentreclam): self
    {
        $this->idcommentreclam = $idcommentreclam;

        return $this;
    }

    public function getIdreclameur(): ?int
    {
        return $this->idreclameur;
    }

    public function setIdreclameur(?int $idreclameur): self
    {
        $this->idreclameur = $idreclameur;

        return $this;
    }


}
