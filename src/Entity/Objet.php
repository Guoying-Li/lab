<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
#[Vich\Uploadable]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Vich\UploadableField(mapping: 'objets', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'objets')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'objets')]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    private ?User $createdBy = null;

    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'objet', cascade: ['persist', 'remove'])]
    private Collection $pret;

    #[ORM\ManyToOne(targetEntity: Modalite::class)]
    #[ORM\JoinColumn(nullable: true)] 
    private ?Modalite $modalite = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->pret = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;
        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategorie(Categorie $categorie): static
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories->add($categorie);
        }
        return $this;
    }

    public function removeCategorie(Categorie $categorie): static
    {
        $this->categories->removeElement($categorie);
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getPret(): Collection
    {
        return $this->pret;
    }

    public function addPret(Pret $pret): self
    {
        if (!$this->pret->contains($pret)) {
            $this->pret[] = $pret;
            $pret->setObjet($this);
        }
        return $this;
    }

    public function removePret(Pret $pret): self
    {
        if ($this->pret->removeElement($pret)) {
            if ($pret->getObjet() === $this) {
                $pret->setObjet(null);
            }
        }
        return $this;
    }

    public function getModalite(): ?Modalite
    {
        return $this->modalite;
    }

    public function setModalite(?Modalite $modalite): self
    {
        $this->modalite = $modalite;
        return $this;
    }

    public function getDispo(): string
    {
        $now = new \DateTime();
        foreach ($this->pret as $pret) {
            if ($now > $pret->getDateDePret() && $now < $pret->getDateDeRetour()) {
                return "non dispo";
            }
        }
        return "dispo";
    }

    public function __toString(): string
    {
        return $this->titre;
    }
}
