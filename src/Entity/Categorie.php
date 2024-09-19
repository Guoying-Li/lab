<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Objet::class, inversedBy: 'categories')]
    private Collection $categorieObjet;

    #[ORM\ManyToMany(targetEntity: Objet::class, mappedBy: 'ObjetCategorie')]
    private Collection $objets;

    public function __construct()
    {
        $this->categorieObjet = new ArrayCollection();
        $this->objets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Objet>
     */
    public function getCategorieObjet(): Collection
    {
        return $this->categorieObjet;
    }

    public function addCategorieObjet(Objet $categorieObjet): static
    {
        if (!$this->categorieObjet->contains($categorieObjet)) {
            $this->categorieObjet->add($categorieObjet);
        }

        return $this;
    }

    public function removeCategorieObjet(Objet $categorieObjet): static
    {
        $this->categorieObjet->removeElement($categorieObjet);

        return $this;
    }

    /**
     * @return Collection<int, Objet>
     */
    public function getObjets(): Collection
    {
        return $this->objets;
    }

    public function addObjet(Objet $objet): static
    {
        if (!$this->objets->contains($objet)) {
            $this->objets->add($objet);
            $objet->addObjetCategorie($this);
        }

        return $this;
    }

    public function removeObjet(Objet $objet): static
    {
        if ($this->objets->removeElement($objet)) {
            $objet->removeObjetCategorie($this);
        }

        return $this;
    }
}
