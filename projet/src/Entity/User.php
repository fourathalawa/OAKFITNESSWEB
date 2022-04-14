<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="NomUser", type="string", length=50, nullable=false)
     */
    private $nomuser;

    /**
     * @var string
     *
     * @ORM\Column(name="PrenomUser", type="string", length=50, nullable=false)
     */
    private $prenomuser;

    /**
     * @var string
     *
     * @ORM\Column(name="MailUser", type="string", length=60, nullable=false)
     */
    private $mailuser;

    /**
     * @var int
     *
     * @ORM\Column(name="TelephoneNumberUser", type="bigint", nullable=false)
     */
    private $telephonenumberuser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissanceUser", type="date", nullable=false)
     */
    private $datenaissanceuser;

    /**
     * @var int
     *
     * @ORM\Column(name="RoleUser", type="integer", nullable=false)
     */
    private $roleuser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="NumeroPackUser", type="integer", nullable=true)
     */
    private $numeropackuser;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateCommence", type="date", nullable=true)
     */
    private $datecommence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ExperienceUser", type="string", length=150, nullable=true)
     */
    private $experienceuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DiplomeUser", type="string", length=150, nullable=true)
     */
    private $diplomeuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="AdresseSalleSport", type="string", length=150, nullable=true)
     */
    private $adressesallesport;

    /**
     * @var int|null
     *
     * @ORM\Column(name="MatriculeFiscale", type="bigint", nullable=true)
     */
    private $matriculefiscale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=45, nullable=true)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="CodeVerification", type="integer", nullable=false)
     */
    private $codeverification;


}
