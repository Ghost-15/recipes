<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $instruction = null;


    #[ORM\OneToMany(targetEntity: CategorieRecipe::class, mappedBy: 'recipe')]
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(string $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getCategorieRecipes(): Collection
    {
        return $this->categorieRecipes;
    }

    public function addCategorieRecipe(CategorieRecipe $categorieRecipe): static
    {
        if (!$this->categorieRecipes->contains($categorieRecipe)) {
            $this->categorieRecipes->add($categorieRecipe);
            $categorieRecipe->setRecipe($this);
        }

        return $this;
    }

    public function removeCategorieRecipe(CategorieRecipe $categorieRecipe): static
    {
        if ($this->categorieRecipes->removeElement($categorieRecipe)) {
            // set the owning side to null (unless already changed)
            if ($categorieRecipe->getRecipe() === $this) {
                $categorieRecipe->setRecipe(null);
            }
        }

        return $this;
    }
}
