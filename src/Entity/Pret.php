<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDeRetour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDePret = null;

    #[ORM\ManyToOne(targetEntity: Modalite::class, inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Modalite $pretModalite = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Objet::class, inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Objet $objet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeRetour(): ?\DateTimeInterface
    {
        return $this->dateDeRetour;
    }

    public function setDateDeRetour(\DateTimeInterface $dateDeRetour): static
    {
        $this->dateDeRetour = $dateDeRetour;
        return $this;
    }

    public function getDateDePret(): ?\DateTimeInterface
    {
        return $this->dateDePret;
    }

    public function setDateDePret(\DateTimeInterface $dateDePret): static
    {
        $this->dateDePret = $dateDePret;
        return $this;
    }

    public function getPretModalite(): ?Modalite
    {
        return $this->pretModalite;
    }

    public function setPretModalite(?Modalite $pretModalite): static
    {
        $this->pretModalite = $pretModalite;
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

    public function getObjet(): ?Objet
    {
        return $this->objet;
    }

    public function setObjet(?Objet $objet): static
    {
        $this->objet = $objet;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            "Prêt du %s au %s",
            $this->dateDePret?->format('d/m/Y') ?? 'N/A',
            $this->dateDeRetour?->format('d/m/Y') ?? 'N/A'
        );
    }
}

