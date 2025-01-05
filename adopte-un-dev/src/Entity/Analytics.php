<?php

namespace App\Entity;

use App\Repository\AnalyticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyticsRepository::class)]
class Analytics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $viewCount = null;

    #[ORM\ManyToOne(inversedBy: 'analytics')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'analytics')]
    private ?JobPost $jobPost = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastViewedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(?int $viewCount): static
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getJobPost(): ?JobPost
    {
        return $this->jobPost;
    }

    public function setJobPost(?JobPost $jobPost): static
    {
        $this->jobPost = $jobPost;

        return $this;
    }

    public function getLastViewedAt(): ?\DateTimeImmutable
    {
        return $this->lastViewedAt;
    }

    public function setLastViewedAt(\DateTimeImmutable $lastViewedAt): static
    {
        $this->lastViewedAt = $lastViewedAt;

        return $this;
    }
}
