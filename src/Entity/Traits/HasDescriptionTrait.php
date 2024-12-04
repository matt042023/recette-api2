<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait HasDescriptionTrait
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    #[Assert\Length(
        max: 5000, 
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    // Ajout d'une méthode pour nettoyer le texte
    public function sanitizeDescription(): void
    {
        if ($this->description) {
            $this->description = trim(strip_tags($this->description));
        }
    }
}
