<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait HasPriorityTrait
{
    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['Recipe:item:get'])]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'La priorité doit être entre {{ min }} et {{ max }}'
    )]
    private int $priority = 0; // Valeur par défaut

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = max(0, min(100, $priority));

        return $this;
    }
}
