<?php

namespace App\Entity;

use App\Repository\FicheDePosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheDePosteRepository::class)]
class FicheDePoste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titrePoste = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $technologiesRecherchees = null;

    #[ORM\Column(nullable: true)]
    private ?int $niveauExpRequis = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbVues = null;

    #[ORM\Column(nullable: true)]
    private ?int $salairePropose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $DescriptionDetaillee = null;

    /**
     * @var Collection<int, Entreprise>
     */
    #[ORM\OneToMany(targetEntity: Entreprise::class, mappedBy: 'ficheDePoste')]
    private Collection $idEntreprise;

    #[ORM\ManyToOne(inversedBy: 'favorisFiche')]
    private ?Dev $dev = null;

    public function __construct()
    {
        $this->idEntreprise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePoste(): ?string
    {
        return $this->titrePoste;
    }

    public function setTitrePoste(?string $titrePoste): static
    {
        $this->titrePoste = $titrePoste;

        return $this;
    }

    public function getTechnologiesRecherchees(): ?string
    {
        return $this->technologiesRecherchees;
    }

    public function setTechnologiesRecherchees(?string $technologiesRecherchees): static
    {
        $this->technologiesRecherchees = $technologiesRecherchees;

        return $this;
    }

    public function getNiveauExpRequis(): ?int
    {
        return $this->niveauExpRequis;
    }

    public function setNiveauExpRequis(?int $niveauExpRequis): static
    {
        $this->niveauExpRequis = $niveauExpRequis;

        return $this;
    }

    public function getNbVues(): ?int
    {
        return $this->nbVues;
    }

    public function setNbVues(?int $nbVues): static
    {
        $this->nbVues = $nbVues;

        return $this;
    }

    public function getSalairePropose(): ?int
    {
        return $this->salairePropose;
    }

    public function setSalairePropose(?int $salairePropose): static
    {
        $this->salairePropose = $salairePropose;

        return $this;
    }

    public function getDescriptionDetaillee(): ?string
    {
        return $this->DescriptionDetaillee;
    }

    public function setDescriptionDetaillee(?string $DescriptionDetaillee): static
    {
        $this->DescriptionDetaillee = $DescriptionDetaillee;

        return $this;
    }

    /**
     * @return Collection<int, Entreprise>
     */
    public function getIdEntreprise(): Collection
    {
        return $this->idEntreprise;
    }

    public function addIdEntreprise(Entreprise $idEntreprise): static
    {
        if (!$this->idEntreprise->contains($idEntreprise)) {
            $this->idEntreprise->add($idEntreprise);
            $idEntreprise->setFicheDePoste($this);
        }

        return $this;
    }

    public function removeIdEntreprise(Entreprise $idEntreprise): static
    {
        if ($this->idEntreprise->removeElement($idEntreprise)) {
            // set the owning side to null (unless already changed)
            if ($idEntreprise->getFicheDePoste() === $this) {
                $idEntreprise->setFicheDePoste(null);
            }
        }

        return $this;
    }

    public function getDev(): ?Dev
    {
        return $this->dev;
    }

    public function setDev(?Dev $dev): static
    {
        $this->dev = $dev;

        return $this;
    }
}
