<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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

 

    #[Vich\UploadableField(mapping: 'objets', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 10000)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'objets')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'objets')]
    #[ORM\JoinColumn(nullable: true, onDelete: "Cascade")]
    private ?User $createdBy = null;

    private $pret;

    private $dispo;

       /**
     * @ORM\ManyToOne(targetEntity=Modalite::class, inversedBy="objets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modalite;

    public function __construct()
    {
        $this->categories = new ArrayCollection();

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

        /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
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

    /**
     * @return Collection<int, Categorie>
     */
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
        if ($this->categories->removeElement($categorie)) 

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

    
    /**
     * @return Collection|Pret[]
     */
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
            // set the owning side to null (unless already changed)
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




}
