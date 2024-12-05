<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\ImageType;
use App\Form\RecipeHasIngredientType;
use App\Form\SourceType;
use App\Form\StepType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('name', 'nom'),

            SlugField::new('slug')->setTargetFieldName('name'),

            TextEditorField::new('description', 'description'),

            DateTimeField::new('createdAt', 'date de création')
                ->hideOnForm(),

            DateTimeField::new('updatedAt', 'date de modification')
            ->hideOnForm(),

            BooleanField::new('draft', 'Brouillon'),

            IntegerField::new('cooking', 'temps de cuisson'),

            IntegerField::new('break', 'Temps de pause'),

            IntegerField::new('preparation', 'temps de preparation'),

            CollectionField::new('steps', 'Etapes')
                ->setEntryType(StepType::class)
                ->allowDelete()
                ->allowAdd(),

            CollectionField::new('images', 'Images')
                ->setEntryType(ImageType::class)
                ->setTemplatePath('admin/fields/Vich_image.html.twig')
                ->allowDelete()
                ->allowAdd(),

            CollectionField::new('sources', 'sources')
                ->setEntryType(SourceType::class)
                ->allowDelete()
                ->allowAdd(),

            AssociationField::new('tags', 'Tags'),

            CollectionField::new('recipeHasIngredients', 'Ingredients nécessaires')
                ->setEntryType(RecipeHasIngredientType::class)
                ->allowDelete()
                ->allowAdd()
                ->setFormTypeOption('by_reference', false),
        ];
    }
}
