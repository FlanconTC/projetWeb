<?php

namespace App\Entity;

use App\Repository\MatchingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchingRepository::class)]
class Matching
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?dev $dev = null;

    #[ORM\ManyToOne]
    private ?Entreprise $entreprise = null;

    #[ORM\Column(nullable: true)]
    private ?int $likeFromDev = null;

    #[ORM\Column(nullable: true)]
    private ?int $likeFromE = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDev(): ?dev
    {
        return $this->dev;
    }

    public function setDev(?dev $dev): static
    {
        $this->dev = $dev;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getLikeFromDev(): ?int
    {
        return $this->likeFromDev;
    }

    public function setLikeFromDev(?int $likeFromDev): static
    {
        $this->likeFromDev = $likeFromDev;

        return $this;
    }

    public function getLikeFromE(): ?int
    {
        return $this->likeFromE;
    }

    public function setLikeFromE(?int $likeFromE): static
    {
        $this->likeFromE = $likeFromE;

        return $this;
    }
}
