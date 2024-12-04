<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('name', 'Nom')
                ->setRequired(true)
                ->setHelp('Nom de la source'),

            TextEditorField::new('description')
                ->setHelp('Description optionnelle de la source'),

            BooleanField::new('vegan', 'Végétalien')
                ->renderAsSwitch(false)
                ->setHelp('Cochez si cet ingrédient est végétalien'),

            BooleanField::new('dairyFree', 'Sans lactose')
                ->renderAsSwitch(false)
                ->setHelp('Cochez si cet ingrédient est sans lactose'),

            BooleanField::new('glutenFree', 'Sans gluten')
                ->renderAsSwitch(false)
                ->setHelp('Cochez si cet ingrédient est sans gluten'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, 
                fn (Action $action) => $action->setIcon('fa fa-plus')->setLabel('Créer un ingrédient'));
    }

}
