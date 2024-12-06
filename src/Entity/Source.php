<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasSizeTrait;
use App\Entity\Traits\HasTimeTrait;
use App\Repository\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ApiResource()]
#[ORM\HasLifecycleCallbacks]
class Source
{
    use HasIdTrait;

    use HasNameTrait;

    use HasDescriptionTrait;

    use HasSizeTrait;

    use HasTimeTrait;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?string $url = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'sources')]
    private Collection $recipe;

    public function __construct()
    {
        $this->recipe = new ArrayCollection();
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipe(): Collection
    {
        return $this->recipe;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipe->contains($recipe)) {
            $this->recipe->add($recipe);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        $this->recipe->removeElement($recipe);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getRecipesSummary(): string
    {
        $recipes = $this->getRecipe()->map(function ($recipe) {
            return $recipe->getName().' ('.$recipe->getId().')';
        })->toArray();

        return implode(', <br>', $recipes) ?: 'Aucun Recette';
    }
}
