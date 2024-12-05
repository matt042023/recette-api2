<?php

namespace App\Controller\Admin;

use App\Entity\IngredientGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IngredientGroup::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Groupe d\'ingrédients')
            ->setEntityLabelInPlural('Groupes d\'ingrédients')
            ->setSearchFields(['name'])
            ->setDefaultSort(['priority' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('name', 'Nom du groupe')
                ->setRequired(true)
                ->setHelp('Nom descriptif du groupe d\'ingrédients'),

            IntegerField::new('priority', 'Ordre de priorité')
                ->setHelp('Définit l\'ordre d\'affichage des groupes (plus le nombre est grand, plus le groupe est prioritaire)')
                ->setDefaultColumns(0),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setIcon('fa fa-layer-group')->setLabel('Créer un groupe d\'ingrédients'));
    }

    // Méthode pour ajouter une validation personnalisée si nécessaire
    public function createEntity(string $entityFqcn): IngredientGroup
    {
        $ingredientGroup = new IngredientGroup();

        // Validation ou logique supplémentaire si besoin
        return $ingredientGroup;
    }
}
