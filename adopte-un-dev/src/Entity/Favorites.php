<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoritesRepository::class)]
class Favorites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?DeveloperProfile $favoriteDeveloper = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?JobPost $favoriteJob = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFavoriteDeveloper(): ?DeveloperProfile
    {
        return $this->favoriteDeveloper;
    }

    public function setFavoriteDeveloper(?DeveloperProfile $favoriteDeveloper): static
    {
        $this->favoriteDeveloper = $favoriteDeveloper;

        return $this;
    }

    public function getFavoriteJob(): ?JobPost
    {
        return $this->favoriteJob;
    }

    public function setFavoriteJob(?JobPost $favoriteJob): static
    {
        $this->favoriteJob = $favoriteJob;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
