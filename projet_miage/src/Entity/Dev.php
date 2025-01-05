<?php

namespace App\Entity;

use App\Repository\DevRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevRepository::class)]
class Dev extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $langagesDeProg = null;

    #[ORM\Column(nullable: true)]
    private ?string $niveauExperience = null;

    #[ORM\Column(nullable: true)]
    private ?int $salaireMin = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $biographie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbVues = null;

    #[ORM\ManyToOne(targetEntity: Entreprise::class, inversedBy: 'idDev')]
    private ?Entreprise $favorisDev = null;

    #[ORM\OneToMany(mappedBy: 'dev', targetEntity: FicheDePoste::class)]
    private Collection $favorisFiche;

    public function __construct()
    {
        $this->favorisFiche = new ArrayCollection();
    }

    public function getLangagesDeProg(): ?string
    {
        return $this->langagesDeProg;
    }

    public function setLangagesDeProg(?string $langagesDeProg): static
    {
        $this->langagesDeProg = $langagesDeProg;

        return $this;
    }

    public function getNiveauExperience(): ?string
    {
        return $this->niveauExperience;
    }

    public function setNiveauExperience(?string $niveauExperience): static
    {
        $this->niveauExperience = $niveauExperience;

        return $this;
    }

    public function getSalaireMin(): ?int
    {
        return $this->salaireMin;
    }

    public function setSalaireMin(?int $salaireMin): static
    {
        $this->salaireMin = $salaireMin;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(?string $biographie): static
    {
        $this->biographie = $biographie;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

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

    public function getFavorisDev(): ?Entreprise
    {
        return $this->favorisDev;
    }

    public function setFavorisDev(?Entreprise $favorisDev): static
    {
        $this->favorisDev = $favorisDev;

        return $this;
    }

    public function getFavorisFiche(): Collection
    {
        return $this->favorisFiche;
    }

    public function addFavorisFiche(FicheDePoste $favorisFiche): static
    {
        if (!$this->favorisFiche->contains($favorisFiche)) {
            $this->favorisFiche->add($favorisFiche);
            $favorisFiche->setDev($this);
        }

        return $this;
    }

    public function removeFavorisFiche(FicheDePoste $favorisFiche): static
    {
        if ($this->favorisFiche->removeElement($favorisFiche)) {
            if ($favorisFiche->getDev() === $this) {
                $favorisFiche->setDev(null);
            }
        }

        return $this;
    }
}
