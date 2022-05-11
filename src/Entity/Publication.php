<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("publication")
     */
    private $idpublication;

    /**
     * @var int
     *
     * @ORM\Column(name="IDuser", type="integer", nullable=false)
     * @Groups("publication")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="DatePublication", type="string", length=255, nullable=false)
     * @Groups("publication")
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Publication", type="string", length=255, nullable=false)
     * @Groups("publication")
     */
    private $publication;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Usernamep", type="string", length=250, nullable=true)
     * @Groups("publication")
     */
    private $usernamep;

    public function getId(): ?int
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

    public function getUsernamep(): ?string
    {
        return $this->usernamep;
    }

    public function setUsernamep(?string $usernamep): self
    {
        $this->usernamep = $usernamep;

        return $this;
    }

    public function getIdpublication(): ?int
    {
        return $this->idpublication;
    }


}