<?php

namespace App\Controller\Admin;

use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UnitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Unit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Unité')
            ->setEntityLabelInPlural('Unités')
            ->setSearchFields(['singular', 'plural'])
            ->setDefaultSort(['singular' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('singular', 'Unité (singulier)')
                ->setRequired(true)
                ->setHelp('Forme singulière de l\'unité (ex: gramme, cuillère)')
                ->setMaxLength(50),

            TextField::new('plural', 'Unité (pluriel)')
                ->setRequired(true)
                ->setHelp('Forme plurielle de l\'unité (ex: grammes, cuillères)')
                ->setMaxLength(50),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setIcon('fa fa-plus')->setLabel('Créer une unité'))
            ->disable(Action::DELETE); // Empêche la suppression directe
    }

    // Méthode optionnelle pour ajouter une validation personnalisée
    public function createEntity(string $entityFqcn): Unit
    {
        $unit = new Unit();

        return $unit;
    }
}
