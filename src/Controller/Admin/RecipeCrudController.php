<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Form\ImageType;
use App\Form\RecipeHasIngredientType;
use App\Form\SourceType;
use App\Form\StepType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInSingular('Recette')
            ->setEntityLabelInPlural('Recettes')
            ->setSearchFields(['name', 'description', 'tags.name'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            // ->showentityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            AssociationField::new('user', 'Utilisateur')
                ->setFormTypeOption('disabled', true)
                ->hideOnIndex(),
            BooleanField::new('draft', 'Brouillon'),

            // IdField::new('id')
            //     ->hideOnForm(),

            TextField::new('name', 'nom'),

            SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex(),

            CollectionField::new('images', 'Images')
            ->setEntryType(ImageType::class) // Le formulaire pour les nouvelles images
            ->allowDelete()
            ->allowAdd()
            ->setTemplatePath('admin/fields/Vich_image_Peview.html.twig'), // Utilisation du fichier existant

            DateTimeField::new('updatedAt', 'date de modification')
            ->hideOnForm(),

            TextEditorField::new('description', 'description'),

            AssociationField::new('tags', 'Tags')
            ->setFormTypeOption('by_reference', false)
            ->formatValue(function ($value, $entity) {
                /* @var Recipe $entity */
                return $entity->getTagsSummary();
            }),

            IntegerField::new('cooking', 'temps de cuisson'),

            IntegerField::new('break', 'Temps de pause'),

            IntegerField::new('preparation', 'temps de preparation'),

            CollectionField::new('recipeHasIngredients', 'Ingrédients')
                ->setEntryType(RecipeHasIngredientType::class)
                ->allowDelete()
                ->allowAdd()
                ->formatValue(function ($value, $entity) {
                    /*
                     * @var Recipe $entity
                     */
                    return $entity->getIngredientsSummary();
                }),

            CollectionField::new('steps', 'Etapes')
                ->setEntryType(StepType::class)
                ->allowDelete()
                ->allowAdd(),

            CollectionField::new('sources', 'sources')
                ->setEntryType(SourceType::class)
                ->allowDelete()
                ->allowAdd()
                ->formatValue(function ($value, $entity) {
                    /* @var Recipe $entity */
                    return $entity->getSourcesSummary();
                }),

            DateTimeField::new('createdAt', 'date de création')
            ->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setIcon('fa fa-utensils')->setLabel('Créer une recette'));
    }

    public function createEntity(string $entityFqcn): Recipe
    {
        $recipe = new Recipe();

        return $recipe;
    }
}
