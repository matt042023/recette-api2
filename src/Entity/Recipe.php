<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimeTrait;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['Recipe:item:get']]
        ),
        new GetCollection(),
        new Delete(),
        new Post(),
        new Patch(),
    ],
)]
#[Vich\Uploadable]
class Recipe
{
    use HasIdTrait;

    use HasNameTrait;

    use HasDescriptionTrait;

    use HasTimeTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private bool $draft;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?int $cooking = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?int $break = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?int $preparation = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $steps;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $images;

    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'recipe', cascade: ['persist', 'remove'])]
    #[Groups(['Recipe:item:get'])]
    private Collection $sources;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'recipe')]
    #[Groups(['Recipe:item:get'])]
    private Collection $tags;

    /**
     * @var Collection<int, RecipeHasIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeHasIngredient::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $recipeHasIngredients;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->recipeHasIngredients = new ArrayCollection();
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): static
    {
        $this->draft = $draft;

        return $this;
    }

    public function getCooking(): ?int
    {
        return $this->cooking;
    }

    public function setCooking(?int $cooking): static
    {
        $this->cooking = $cooking;

        return $this;
    }

    public function getBreak(): ?int
    {
        return $this->break;
    }

    public function setBreak(?int $break): static
    {
        $this->break = $break;

        return $this;
    }

    public function getPreparation(): ?int
    {
        return $this->preparation;
    }

    public function setPreparation(?int $preparation): static
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setRecipe($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRecipe() === $this) {
                $image->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Source>
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(Source $source): static
    {
        if (!$this->sources->contains($source)) {
            $this->sources->add($source);
            $source->addRecipe($this);
        }

        return $this;
    }

    public function removeSource(Source $source): static
    {
        if ($this->sources->removeElement($source)) {
            $source->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addRecipe($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeRecipe($this);
        }

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
            $recipeHasIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if ($this->recipeHasIngredients->removeElement($recipeHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasIngredient->getRecipe() === $this) {
                $recipeHasIngredient->setRecipe(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName().' ('.$this->getId().')';
    }
}
