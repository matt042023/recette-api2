<?php

namespace App\Namer;

use App\Entity\Image;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

/**
 * @implements DirectoryNamerInterface<Image>
 */
class ImageDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * @param Image|array<Image> $object
     */
    public function directoryName(object|array $object, PropertyMapping $mapping): string
    {
        // Si $object est un tableau, prenez le premier élément
        if (is_array($object)) {
            $object = $object[0];
        }

        // Récupérer la recette et l'étape associées
        $recipe = $object->getRecipe();
        $step = $object->getStep();

        if (!is_null($step)) {
            // Récupérer la recette liée à l'étape
            $recipe = $step->getRecipe();
        }

        if (is_null($recipe)) {
            // Si l'image n'est liée à aucune recette ou étape
            throw new \Exception("L'image n'est liée à aucune étape ni recette.");
        }

        // Le nom du dossier qui stocke l'image sera le slug de la recette
        $directoryName = $recipe->getSlug();

        // Si l'image est liée à une étape
        if (!is_null($step)) {
            // L'image sera stockée dans un sous-dossier portant le slug de l'étape
            $directoryName .= '/'.$step->getSlug();
        }

        return $directoryName;
    }
}
