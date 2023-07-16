<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Projets
 *
 * @ORM\Table(name="projets")
 * @ORM\Entity
 */
class Projets
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_proj", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refProj;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_dem", type="string", length=255, nullable=false)
     */
    private $nomDem;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_dem", type="string", length=255, nullable=false)
     */
    private $prenomDem;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite_dem", type="string", length=255, nullable=false)
     */
    private $civiliteDem;

    /**
     * @var int
     *
     * @ORM\Column(name="telephone_dem", type="integer", nullable=false)
     */
    private $telephoneDem;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_dem", type="string", length=255, nullable=false)
     */
    private $adresseDem;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_dem", type="string", length=255, nullable=false)
     */
    private $villeDem;

    /**
     * @var int
     *
     * @ORM\Column(name="codepostale_dem", type="integer", nullable=false)
     */
    private $codepostaleDem;

    /**
     * @var string
     *
     * @ORM\Column(name="email_dem", type="string", length=255, nullable=false)
     */
    private $emailDem;

    /**
     * @var string
     *
     * @ORM\Column(name="titreprojet", type="string", length=255, nullable=false)
     */
    private $titreprojet;

    /**
     * @var string
     *
     * @ORM\Column(name="situation_proj", type="string", length=255, nullable=false)
     */
    private $situationProj;

    /**
     * @var string
     *
     * @ORM\Column(name="type_bien", type="string", length=255, nullable=false)
     */
    private $typeBien;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_bien", type="string", length=255, nullable=false)
     */
    private $etatBien;

    /**
     * @var string
     *
     * @ORM\Column(name="description_proj", type="text", length=65535, nullable=false)
     */
    private $descriptionProj;

    /**
     * @var string
     *
     * @ORM\Column(name="objet_dem_proj", type="string", length=255, nullable=false)
     */
    private $objetDemProj;

    /**
     * @var int
     *
     * @ORM\Column(name="budget_proj", type="integer", nullable=false)
     */
    private $budgetProj;

    /**
     * @var string
     *
     * @ORM\Column(name="delai_realisation", type="string", length=255, nullable=false)
     */
    private $delaiRealisation;

    /**
     * @var string
     *
     * @ORM\Column(name="periode_rappel", type="string", length=255, nullable=false)
     */
    private $periodeRappel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_dem_proj", type="date", nullable=false)
     */
    private $dateDemProj;

    public function getRefProj(): ?int
    {
        return $this->refProj;
    }

    public function getNomDem(): ?string
    {
        return $this->nomDem;
    }

    public function setNomDem(string $nomDem): static
    {
        $this->nomDem = $nomDem;

        return $this;
    }

    public function getPrenomDem(): ?string
    {
        return $this->prenomDem;
    }

    public function setPrenomDem(string $prenomDem): static
    {
        $this->prenomDem = $prenomDem;

        return $this;
    }

    public function getCiviliteDem(): ?string
    {
        return $this->civiliteDem;
    }

    public function setCiviliteDem(string $civiliteDem): static
    {
        $this->civiliteDem = $civiliteDem;

        return $this;
    }

    public function getTelephoneDem(): ?int
    {
        return $this->telephoneDem;
    }

    public function setTelephoneDem(int $telephoneDem): static
    {
        $this->telephoneDem = $telephoneDem;

        return $this;
    }

    public function getAdresseDem(): ?string
    {
        return $this->adresseDem;
    }

    public function setAdresseDem(string $adresseDem): static
    {
        $this->adresseDem = $adresseDem;

        return $this;
    }

    public function getVilleDem(): ?string
    {
        return $this->villeDem;
    }

    public function setVilleDem(string $villeDem): static
    {
        $this->villeDem = $villeDem;

        return $this;
    }

    public function getCodepostaleDem(): ?int
    {
        return $this->codepostaleDem;
    }

    public function setCodepostaleDem(int $codepostaleDem): static
    {
        $this->codepostaleDem = $codepostaleDem;

        return $this;
    }

    public function getEmailDem(): ?string
    {
        return $this->emailDem;
    }

    public function setEmailDem(string $emailDem): static
    {
        $this->emailDem = $emailDem;

        return $this;
    }

    public function getTitreprojet(): ?string
    {
        return $this->titreprojet;
    }

    public function setTitreprojet(string $titreprojet): static
    {
        $this->titreprojet = $titreprojet;

        return $this;
    }

    public function getSituationProj(): ?string
    {
        return $this->situationProj;
    }

    public function setSituationProj(string $situationProj): static
    {
        $this->situationProj = $situationProj;

        return $this;
    }

    public function getTypeBien(): ?string
    {
        return $this->typeBien;
    }

    public function setTypeBien(string $typeBien): static
    {
        $this->typeBien = $typeBien;

        return $this;
    }

    public function getEtatBien(): ?string
    {
        return $this->etatBien;
    }

    public function setEtatBien(string $etatBien): static
    {
        $this->etatBien = $etatBien;

        return $this;
    }

    public function getDescriptionProj(): ?string
    {
        return $this->descriptionProj;
    }

    public function setDescriptionProj(string $descriptionProj): static
    {
        $this->descriptionProj = $descriptionProj;

        return $this;
    }

    public function getObjetDemProj(): ?string
    {
        return $this->objetDemProj;
    }

    public function setObjetDemProj(string $objetDemProj): static
    {
        $this->objetDemProj = $objetDemProj;

        return $this;
    }

    public function getBudgetProj(): ?int
    {
        return $this->budgetProj;
    }

    public function setBudgetProj(int $budgetProj): static
    {
        $this->budgetProj = $budgetProj;

        return $this;
    }

    public function getDelaiRealisation(): ?string
    {
        return $this->delaiRealisation;
    }

    public function setDelaiRealisation(string $delaiRealisation): static
    {
        $this->delaiRealisation = $delaiRealisation;

        return $this;
    }

    public function getPeriodeRappel(): ?string
    {
        return $this->periodeRappel;
    }

    public function setPeriodeRappel(string $periodeRappel): static
    {
        $this->periodeRappel = $periodeRappel;

        return $this;
    }

    public function getDateDemProj(): ?\DateTimeInterface
    {
        return $this->dateDemProj;
    }

    public function setDateDemProj(\DateTimeInterface $dateDemProj): static
    {
        $this->dateDemProj = $dateDemProj;

        return $this;
    }


}
