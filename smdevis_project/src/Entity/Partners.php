<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Partners
 *
 * @ORM\Table(name="partners")
 * @ORM\Entity
 */
class Partners
{
    /**
     * @var int
     *
     * @ORM\Column(name="part_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $partId;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false, options={"default"="User"})
     */
    private $role = 'User';

    /**
     * @var string|null
     *
     * @ORM\Column(name="login_code", type="string", length=255, nullable=true)
     */
    private $loginCode;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=200, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_soc", type="string", length=255, nullable=false)
     */
    private $nomSoc;

    /**
     * @var string
     *
     * @ORM\Column(name="act_entreprise", type="string", length=255, nullable=false)
     */
    private $actEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="mat_fisc", type="string", length=255, nullable=false)
     */
    private $matFisc;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="tel_gsm", type="integer", nullable=false)
     */
    private $telGsm;

    /**
     * @var int
     *
     * @ORM\Column(name="tel_fix", type="integer", nullable=false)
     */
    private $telFix;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=200, nullable=false)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="codepostal", type="integer", nullable=false)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="subscription", type="string", length=255, nullable=false)
     */
    private $subscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_part_sub", type="date", nullable=false)
     */
    private $datePartSub;

    public function getPartId(): ?int
    {
        return $this->partId;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getLoginCode(): ?string
    {
        return $this->loginCode;
    }

    public function setLoginCode(?string $loginCode): static
    {
        $this->loginCode = $loginCode;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomSoc(): ?string
    {
        return $this->nomSoc;
    }

    public function setNomSoc(string $nomSoc): static
    {
        $this->nomSoc = $nomSoc;

        return $this;
    }

    public function getActEntreprise(): ?string
    {
        return $this->actEntreprise;
    }

    public function setActEntreprise(string $actEntreprise): static
    {
        $this->actEntreprise = $actEntreprise;

        return $this;
    }

    public function getMatFisc(): ?string
    {
        return $this->matFisc;
    }

    public function setMatFisc(string $matFisc): static
    {
        $this->matFisc = $matFisc;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelGsm(): ?int
    {
        return $this->telGsm;
    }

    public function setTelGsm(int $telGsm): static
    {
        $this->telGsm = $telGsm;

        return $this;
    }

    public function getTelFix(): ?int
    {
        return $this->telFix;
    }

    public function setTelFix(int $telFix): static
    {
        $this->telFix = $telFix;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getSubscription(): ?string
    {
        return $this->subscription;
    }

    public function setSubscription(string $subscription): static
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getDatePartSub(): ?\DateTimeInterface
    {
        return $this->datePartSub;
    }

    public function setDatePartSub(\DateTimeInterface $datePartSub): static
    {
        $this->datePartSub = $datePartSub;

        return $this;
    }


}
