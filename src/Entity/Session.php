<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity
 */
class Session
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="roleUser", type="integer", nullable=false)
     */
    private $roleuser;

    /**
     * @var int
     *
     * @ORM\Column(name="idSession", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsession;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getRoleuser(): ?int
    {
        return $this->roleuser;
    }

    public function setRoleuser(int $roleuser): self
    {
        $this->roleuser = $roleuser;

        return $this;
    }

    public function getIdsession(): ?int
    {
        return $this->idsession;
    }


}