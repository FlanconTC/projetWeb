<?php

namespace App\Entity;

use App\Repository\DeveloperProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeveloperProfileRepository::class)]
class DeveloperProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'developerProfile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?array $programmingLanguages = null;

    #[ORM\Column(nullable: true)]
    private ?int $experienceLevel = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimunSalary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $avatar;

    /**
     * @var Collection<int, Favorites>
     */
    #[ORM\OneToMany(targetEntity: Favorites::class, mappedBy: 'favoriteDeveloper')]
    private Collection $favorites;

    /**
     * @var Collection<int, Matching>
     */
    #[ORM\OneToMany(targetEntity: Matching::class, mappedBy: 'developer')]
    private Collection $matchings;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->matchings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getProgrammingLanguages(): ?array
    {
        return $this->programmingLanguages;
    }

    public function setProgrammingLanguages(?array $programmingLanguages): static
    {
        $this->programmingLanguages = $programmingLanguages;

        return $this;
    }

    public function getExperienceLevel(): ?int
    {
        return $this->experienceLevel;
    }

    public function setExperienceLevel(?int $experienceLevel): static
    {
        $this->experienceLevel = $experienceLevel;

        return $this;
    }

    public function getMinimunSalary(): ?int
    {
        return $this->minimunSalary;
    }

    public function setMinimunSalary(?int $minimunSalary): static
    {
        $this->minimunSalary = $minimunSalary;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Favorites>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorites $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setFavoriteDeveloper($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavoriteDeveloper() === $this) {
                $favorite->setFavoriteDeveloper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matching>
     */
    public function getMatchings(): Collection
    {
        return $this->matchings;
    }

    public function addMatching(Matching $matching): static
    {
        if (!$this->matchings->contains($matching)) {
            $this->matchings->add($matching);
            $matching->setDeveloper($this);
        }

        return $this;
    }

    public function removeMatching(Matching $matching): static
    {
        if ($this->matchings->removeElement($matching)) {
            // set the owning side to null (unless already changed)
            if ($matching->getDeveloper() === $this) {
                $matching->setDeveloper(null);
            }
        }

        return $this;
    }

}
