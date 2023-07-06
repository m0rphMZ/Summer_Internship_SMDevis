<?php

namespace App\Entity;

use App\Repository\PropositionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Propositions
 *
 * @ORM\Table(name="propositions", indexes={@ORM\Index(name="fk_ref_proj", columns={"ref_proj"})})
 * @ORM\Entity(repositoryClass = "App\Repository\PropositionsRepository")
 */
class Propositions
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_proposition", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refProposition;

    /**
     * @var string
     *
     * @ORM\Column(name="proprietaire_proposition", type="string", length=255, nullable=false)
     */
    private $proprietaireProposition;

    /**
     * @var string
     *
     * @ORM\Column(name="description_proposition", type="string", length=250, nullable=false)
     */
    private $descriptionProposition;

    /**
     * @var \Projects
     *
     * @ORM\ManyToOne(targetEntity="Projects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_proj", referencedColumnName="ref_proj")
     * })
     */
    private $refProj;

    public function getRefProposition(): ?int
    {
        return $this->refProposition;
    }

    public function getProprietaireProposition(): ?string
    {
        return $this->proprietaireProposition;
    }

    public function setProprietaireProposition(string $proprietaireProposition): static
    {
        $this->proprietaireProposition = $proprietaireProposition;

        return $this;
    }

    public function getDescriptionProposition(): ?string
    {
        return $this->descriptionProposition;
    }

    public function setDescriptionProposition(string $descriptionProposition): static
    {
        $this->descriptionProposition = $descriptionProposition;

        return $this;
    }

    public function getRefProj(): ?Projects
    {
        return $this->refProj;
    }

    public function setRefProj(?Projects $refProj): static
    {
        $this->refProj = $refProj;

        return $this;
    }


}
