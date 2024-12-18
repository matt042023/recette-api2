<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\HasIdTrait;
use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
#[ApiResource()]
class Unit
{
    use HasIdTrait;

    #[ORM\Column(length: 50)]
    #[Groups(['Recipe:item:get'])]
    private string $singular;

    #[ORM\Column(length: 50)]
    #[Groups(['Recipe:item:get'])]
    private string $plural;

    /**
     * @var Collection<int, RecipeHasIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeHasIngredient::class, mappedBy: 'unit')]
    private Collection $recipeHasIngredients;

    public function __construct()
    {
        $this->recipeHasIngredients = new ArrayCollection();
    }

    public function getSingular(): string
    {
        return $this->singular;
    }

    public function setSingular(string $singular): static
    {
        $this->singular = $singular;

        return $this;
    }

    public function getPlural(): string
    {
        return $this->plural;
    }

    public function setPlural(string $plural): static
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * @return Collection<int, RecipeHasIngredient>
     */
    public function getRecipeHasIngredients(): Collection
    {
        return $this->recipeHasIngredients;
    }

    public function addRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if (!$this->recipeHasIngredients->contains($recipeHasIngredient)) {
            $this->recipeHasIngredients->add($recipeHasIngredient);
            $recipeHasIngredient->setUnit($this);
        }

        return $this;
    }

    public function removeRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if ($this->recipeHasIngredients->removeElement($recipeHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasIngredient->getUnit() === $this) {
                $recipeHasIngredient->setUnit(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->singular.' ('.$this->plural.')';
    }
}
