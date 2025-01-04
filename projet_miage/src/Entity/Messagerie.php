<?php

namespace App\Entity;

use App\Repository\MessagerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagerieRepository::class)]
class Messagerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $luDev = null;

    #[ORM\Column(nullable: true)]
    private ?bool $luE = null;

    #[ORM\ManyToOne]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne]
    private ?Dev $dev = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isLuDev(): ?bool
    {
        return $this->luDev;
    }

    public function setLuDev(?bool $luDev): static
    {
        $this->luDev = $luDev;

        return $this;
    }

    public function isLuE(): ?bool
    {
        return $this->luE;
    }

    public function setLuE(?bool $luE): static
    {
        $this->luE = $luE;

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

    public function getDev(): ?Dev
    {
        return $this->dev;
    }

    public function setDev(?Dev $dev): static
    {
        $this->dev = $dev;

        return $this;
    }
}
