<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'categorieObjet')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'objets')]
    private ?User $ObjetUser = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'objets')]
    private Collection $ObjetCategorie;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->ObjetCategorie = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addCategorieObjet($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCategorieObjet($this);
        }

        return $this;
    }

    public function getObjetUser(): ?User
    {
        return $this->ObjetUser;
    }

    public function setObjetUser(?User $ObjetUser): static
    {
        $this->ObjetUser = $ObjetUser;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getObjetCategorie(): Collection
    {
        return $this->ObjetCategorie;
    }

    public function addObjetCategorie(Categorie $objetCategorie): static
    {
        if (!$this->ObjetCategorie->contains($objetCategorie)) {
            $this->ObjetCategorie->add($objetCategorie);
        }

        return $this;
    }

    public function removeObjetCategorie(Categorie $objetCategorie): static
    {
        $this->ObjetCategorie->removeElement($objetCategorie);

        return $this;
    }
}
