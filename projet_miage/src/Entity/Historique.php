<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recherche = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'historique')]
    private Collection $idUser;

    public function __construct()
    {
        $this->idUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    public function setRecherche(?string $recherche): static
    {
        $this->recherche = $recherche;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Utilisateur $idUser): static
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser->add($idUser);
            $idUser->setHistorique($this);
        }

        return $this;
    }

    public function removeIdUser(Utilisateur $idUser): static
    {
        if ($this->idUser->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getHistorique() === $this) {
                $idUser->setHistorique(null);
            }
        }

        return $this;
    }
}
