<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\HasIdTrait;
use App\Repository\RecipeHasIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeHasIngredientRepository::class)]
#[ApiResource]
class RecipeHasIngredient
{
    use HasIdTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private float $quantity;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private bool $isOptional = false;

    #[ORM\ManyToOne(inversedBy: 'recipeHasIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private Recipe $recipe;

    #[ORM\ManyToOne(inversedBy: 'recipeHasIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Recipe:item:get'])]
    private Ingredient $ingredient;

    #[ORM\ManyToOne(inversedBy: 'recipeHasIngredients')]
    #[Groups(['Recipe:item:get'])]
    private ?IngredientGroup $ingredientGroup = null;

    #[ORM\ManyToOne(inversedBy: 'recipeHasIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Recipe:item:get'])]
    private Unit $unit;

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isOptional(): bool
    {
        return $this->isOptional;
    }

    public function setIsOptional(bool $isOptional): self
    {
        $this->isOptional = $isOptional;

        return $this;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getIngredientGroup(): IngredientGroup
    {
        return $this->ingredientGroup;
    }

    public function setIngredientGroup(?IngredientGroup $ingredientGroup): static
    {
        $this->ingredientGroup = $ingredientGroup;

        return $this;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function __toString()
    {
        return $this->getIngredient()->getName().' ('.$this->getQuantity().$this->getUnit().')';
    }
}
