<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise extends Utilisateur
{
    #[ORM\OneToMany(mappedBy: 'favorisDev', targetEntity: Dev::class)]
    private Collection $idDev;

    #[ORM\ManyToOne(targetEntity: FicheDePoste::class, inversedBy: 'idEntreprise')]
    private ?FicheDePoste $ficheDePoste = null;

    public function __construct()
    {
        $this->idDev = new ArrayCollection();
    }

    public function getIdDev(): Collection
    {
        return $this->idDev;
    }

    public function addIdDev(Dev $idDev): static
    {
        if (!$this->idDev->contains($idDev)) {
            $this->idDev->add($idDev);
            $idDev->setFavorisDev($this);
        }

        return $this;
    }

    public function removeIdDev(Dev $idDev): static
    {
        if ($this->idDev->removeElement($idDev)) {
            if ($idDev->getFavorisDev() === $this) {
                $idDev->setFavorisDev(null);
            }
        }

        return $this;
    }

    public function getFicheDePoste(): ?FicheDePoste
    {
        return $this->ficheDePoste;
    }

    public function setFicheDePoste(?FicheDePoste $ficheDePoste): static
    {
        $this->ficheDePoste = $ficheDePoste;

        return $this;
    }
}
