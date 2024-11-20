<?php

namespace App\Entity;

use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasPriorityTrait;
use App\Repository\IngredientGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientGroupRepository::class)]
class IngredientGroup
{
    use HasIdTrait;

    use HasNameTrait;

    use HasPriorityTrait;
}
