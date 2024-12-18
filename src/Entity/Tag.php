<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasPriorityTrait;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource]
class Tag
{
    use HasIdTrait;

    use HasNameTrait;

    use HasDescriptionTrait;

    use HasPriorityTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private bool $menu;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(onDelete: 'SET NULL', nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?self $parent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[Groups(['Recipe:item:get'])]
    private Collection $children;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\ManyToMany(targetEntity: Recipe::class, inversedBy: 'tags')]
    private Collection $recipe;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->recipe = new ArrayCollection();
    }

    public function isMenu(): bool
    {
        return $this->menu;
    }

    public function setMenu(bool $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

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

    public function __toString()
    {
        return $this->getName().' ('.$this->getId().')';
    }

    public function getTagsSummary(): string
    {
        $tags = $this->getChildren()->map(function ($tag) {
            return $tag->getName().' ('.$tag->getId().')'; // Assurez-vous que la méthode getName() existe dans l'entité Tag
        })->toArray();

        return implode(', ', $tags) ?: 'Aucun tag';
    }
}
