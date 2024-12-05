<?php

namespace App\Controller\Admin;

use App\Entity\Source;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Source::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Source')
            ->setEntityLabelInPlural('Sources')
            ->setSearchFields(['name', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')
                ->hideOnForm(),

            TextField::new('name', 'Nom')
                ->setRequired(true)
                ->setHelp('Nom de la source'),

            TextEditorField::new('description', 'Description')
                ->setHelp('Description optionnelle de la source'),

            UrlField::new('url', 'URL')
                ->setHelp('URL de la source'),

            IntegerField::new('size', 'Taille')
                ->setHelp('Définit l\'ordre d\'affichage (plus le nombre est grand, plus la source est prioritaire)')
                ->setDefaultColumns(0),

            AssociationField::new('recipe', 'Recettes associées')
                ->setHelp('Optionnel : sélectionnez une entité liée si nécessaire')
                ->setFormTypeOption('by_reference', false)
                ->hideOnIndex(),
        ];
    }

    // Optionnel : personnaliser les actions
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action->setIcon('fa fa-plus')->setLabel('Créer une source'));
    }
}
