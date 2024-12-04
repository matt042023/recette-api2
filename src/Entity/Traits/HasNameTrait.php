<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait HasNameTrait
{
    #[ORM\Column(length: 128)]
    #[Groups(['Recipe:item:get'])]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(
        min: 2, 
        max: 128, 
        minMessage: "Le nom doit faire au moins {{ limit }} caractères",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    private string $name = '';

    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'], unique: true)]
    #[Assert\Regex(
        pattern: '/^[a-z0-9-]+$/', 
        message: "Le slug ne peut contenir que des lettres minuscules, des chiffres et des traits d'union"
    )]
    private string $slug;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

     // Ajout d'une méthode pour générer manuellement un slug si nécessaire
     public function generateSlug(): string
     {
         $slug = transliterator_transliterate(
             'Any-Latin; Latin-ASCII; Lower(); [:Punctuation:] Remove; Space_Remove',
             $this->name
         );
         return str_replace(' ', '-', $slug);
     }
}
