<?php

namespace App\Entity;

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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var string|null
     *
     * @ORM\Column(name="Usernamep", type="string", length=250, nullable=true)
     */
    private $usernamep;

    public function getId(): ?int
    {
        return $this->id;
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
