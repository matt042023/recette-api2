<?php

namespace App\Entity;

use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasSizeTrait;
use App\Repository\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    use HasIdTrait;

    use HasNameTrait;

    use HasDescriptionTrait;

    use HasSizeTrait;

    use TimestampableEntity;

    #[ORM\Column(length: 255, nullable: true)]
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
}
