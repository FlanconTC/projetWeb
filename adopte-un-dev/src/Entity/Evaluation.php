<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'givenEvaluations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $evaluator = null;
    
    #[ORM\ManyToOne(inversedBy: 'receivedEvaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $evaluatee = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comments = null;

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

    public function getEvaluator(): ?User
    {
        return $this->evaluator;
    }

    public function setEvaluator(?User $evaluator): static
    {
        $this->evaluator = $evaluator;

        return $this;
    }

    public function getEvaluatee(): ?User
    {
        return $this->evaluatee;
    }

    public function setEvaluatee(?User $evaluatee): static
    {
        $this->evaluatee = $evaluatee;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

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
