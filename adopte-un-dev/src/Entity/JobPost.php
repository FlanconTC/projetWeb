<?php

namespace App\Entity;

use App\Repository\JobPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobPostRepository::class)]
class JobPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $company = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?array $requiredTechnologies = null;

    #[ORM\Column(nullable: true)]
    private ?int $requiredExperience = null;

    #[ORM\Column(nullable: true)]
    private ?int $offeredSalary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Favorites>
     */
    #[ORM\OneToMany(targetEntity: Favorites::class, mappedBy: 'favoriteJob')]
    private Collection $favorites;

    /**
     * @var Collection<int, Matching>
     */
    #[ORM\OneToMany(targetEntity: Matching::class, mappedBy: 'jobPost')]
    private Collection $matchings;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->matchings = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?user
    {
        return $this->company;
    }

    public function setCompany(?user $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getRequiredTechnologies(): ?array
    {
        return $this->requiredTechnologies;
    }

    public function setRequiredTechnologies(?array $requiredTechnologies): static
    {
        $this->requiredTechnologies = $requiredTechnologies;

        return $this;
    }

    public function getRequiredExperience(): ?int
    {
        return $this->requiredExperience;
    }

    public function setRequiredExperience(?int $requiredExperience): static
    {
        $this->requiredExperience = $requiredExperience;

        return $this;
    }

    public function getOfferedSalary(): ?int
    {
        return $this->offeredSalary;
    }

    public function setOfferedSalary(?int $offeredSalary): static
    {
        $this->offeredSalary = $offeredSalary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $favorite->setFavoriteJob($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavoriteJob() === $this) {
                $favorite->setFavoriteJob(null);
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
            $matching->setJobPost($this);
        }

        return $this;
    }

    public function removeMatching(Matching $matching): static
    {
        if ($this->matchings->removeElement($matching)) {
            // set the owning side to null (unless already changed)
            if ($matching->getJobPost() === $this) {
                $matching->setJobPost(null);
            }
        }

        return $this;
    }
}
