<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


/**
 * Projects
 *
 * @ORM\Table(name="projects", indexes={@ORM\Index(name="fk_user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass = "App\Repository\ProjectsRepository")
 */
class Projects
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
     * @ORM\Column(name="titre", type="string", length=200, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="obj_demande", type="string", length=200, nullable=false)
     */
    private $objDemande;

    /**
     * @var int
     *
     * @ORM\Column(name="budget", type="integer", nullable=false)
     */
    private $budget;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_dem", type="date", nullable=false)
     */
    private $dateDem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delail", type="date", nullable=false)
     */
    private $delail;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    public function getRefProj(): ?int
    {
        return $this->refProj;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getObjDemande(): ?string
    {
        return $this->objDemande;
    }

    public function setObjDemande(string $objDemande): static
    {
        $this->objDemande = $objDemande;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDateDem(): ?\DateTimeInterface
    {
        return $this->dateDem;
    }

    public function setDateDem(\DateTimeInterface $dateDem): static
    {
        $this->dateDem = $dateDem;

        return $this;
    }

    public function getDelail(): ?\DateTimeInterface
    {
        return $this->delail;
    }

    public function setDelail(\DateTimeInterface $delail): static
    {
        $this->delail = $delail;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }


}
