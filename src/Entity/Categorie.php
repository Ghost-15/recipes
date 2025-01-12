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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, CategorieRecipe>
     */
    #[ORM\OneToMany(targetEntity: CategorieRecipe::class, mappedBy: 'categorie')]
    private Collection $categorieRecipes;

    public function __construct()
    {
        $this->categorieRecipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CategorieRecipe>
     */
    public function getCategorieRecipes(): Collection
    {
        return $this->categorieRecipes;
    }

    public function addCategorieRecipe(CategorieRecipe $categorieRecipe): static
    {
        if (!$this->categorieRecipes->contains($categorieRecipe)) {
            $this->categorieRecipes->add($categorieRecipe);
            $categorieRecipe->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorieRecipe(CategorieRecipe $categorieRecipe): static
    {
        if ($this->categorieRecipes->removeElement($categorieRecipe)) {
            // set the owning side to null (unless already changed)
            if ($categorieRecipe->getCategorie() === $this) {
                $categorieRecipe->setCategorie(null);
            }
        }

        return $this;
    }
}
