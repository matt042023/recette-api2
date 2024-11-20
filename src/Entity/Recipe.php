<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    use HasIdTrait;

    use HasNameTrait;

    use HasDescriptionTrait;

    use TimestampableEntity;

    #[ORM\Column]
    private ?bool $draft = null;


    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $cooking = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $break = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $preparation = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', orphanRemoval: true)]
    private Collection $steps;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'recipe')]
    private Collection $images;

    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'recipe')]
    private Collection $sources;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->sources = new ArrayCollection();
    }

    public function isDraft(): ?bool
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
}
