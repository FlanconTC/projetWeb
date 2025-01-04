<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    #[ORM\ManyToOne]
    private ?Dev $devEvaluateur = null;

    #[ORM\ManyToOne]
    private ?Dev $devEvalue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getDevEvaluateur(): ?Dev
    {
        return $this->devEvaluateur;
    }

    public function setDevEvaluateur(?Dev $devEvaluateur): static
    {
        $this->devEvaluateur = $devEvaluateur;

        return $this;
    }

    public function getDevEvalue(): ?Dev
    {
        return $this->devEvalue;
    }

    public function setDevEvalue(?Dev $devEvalue): static
    {
        $this->devEvalue = $devEvalue;

        return $this;
    }
}
