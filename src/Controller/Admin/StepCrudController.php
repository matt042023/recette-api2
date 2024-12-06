<?php

namespace App\Controller\Admin;

use App\Entity\Step;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StepCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Step::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Etape')
            ->setEntityLabelInPlural('Etapes')
            ->setSearchFields(['content'])
            ->setDefaultSort(['recipe' => 'ASC']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('recipe', 'Recette associée')
                ->setHelp('sélectionnez une recette liée si nécessaire')
                ->setFormTypeOption('by_reference', false),
                
            IdField::new('id')
                ->hideOnForm(),

            IntegerField::new('priority', 'Ordre de priorité')
                ->setHelp('Définit l\'ordre d\'affichage (plus le nombre est grand, plus le tag est prioritaire)')
                ->setDefaultColumns(0),

            TextEditorField::new('content', 'Contenu')
            ->setHelp('Description de l\'étape'),

            

                CollectionField::new('images', 'Images')
                ->setEntryType(ImageType::class) // Le formulaire pour les nouvelles images
                ->allowDelete()
                ->allowAdd()
                ->setTemplatePath('admin/fields/Vich_image_Peview.html.twig'), // Utilisation du fichier existant
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une étape');
            });
    }

    public function createEntity(string $entityFqcn)
    {
        $step = new Step();

        return $step;
    }

}
