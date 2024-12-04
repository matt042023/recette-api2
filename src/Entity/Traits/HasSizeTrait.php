<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait HasSizeTrait
{
    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    #[Assert\Positive(message: "La taille doit être un nombre positif")]
    #[Assert\Range(
        min: 1,
        max: 1000000,
        notInRangeMessage: "La taille doit être entre {{ min }} et {{ max }}"
    )]
    private int $size = 1; // Valeur par défaut

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = max(1, $size);

        return $this;
    }
}
