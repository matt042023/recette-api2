<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Tag')
            ->setEntityLabelInPlural('Tags')
            ->setSearchFields(['name', 'description'])
            ->setDefaultSort(['priority' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            
            TextField::new('name', 'Nom')
                ->setRequired(true)
                ->setHelp('Nom du tag'),
            
            TextEditorField::new('description')
                ->setHelp('Description optionnelle du tag'),
            
            BooleanField::new('menu', 'Afficher dans le menu')
                ->renderAsSwitch(false)
                ->setHelp('Cochez si ce tag doit apparaître dans le menu'),
            
            IntegerField::new('priority', 'Ordre de priorité')
                ->setHelp('Définit l\'ordre d\'affichage (plus le nombre est grand, plus le tag est prioritaire)')
                ->setDefaultColumns(0),
            
            AssociationField::new('parent', 'Tag Parent')
                ->setHelp('Optionnel : sélectionnez un tag parent si nécessaire')
                ->autocomplete(),
            
            AssociationField::new('children', 'Sous-tags')
                ->setFormTypeOption('by_reference', false)
                ->hideOnIndex()
        ];
    }

    // Optionnel : personnaliser les actions
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, 
                fn (Action $action) => $action->setIcon('fa fa-plus')->setLabel('Créer un tag'));
    }
}