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
    private ?\DateTimeInterface $date_de_retour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_de_pret = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    private ?Modalite $PretModalite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeRetour(): ?\DateTimeInterface
    {
        return $this->date_de_retour;
    }

    public function setDateDeRetour(\DateTimeInterface $date_de_retour): static
    {
        $this->date_de_retour = $date_de_retour;

        return $this;
    }

    public function getDateDePret(): ?\DateTimeInterface
    {
        return $this->date_de_pret;
    }

    public function setDateDePret(\DateTimeInterface $date_de_pret): static
    {
        $this->date_de_pret = $date_de_pret;

        return $this;
    }

    public function getPretModalite(): ?Modalite
    {
        return $this->PretModalite;
    }

    public function setPretModalite(?Modalite $PretModalite): static
    {
        $this->PretModalite = $PretModalite;

        return $this;
    }
}
