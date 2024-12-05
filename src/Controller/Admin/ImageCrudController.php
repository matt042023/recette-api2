<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'nom'),
            SlugField::new('slug')->setTargetFieldName('name'),
            VichImageField::new('imageFile', 'Image'),
            TextEditorField::new('description', 'description'),
            IntegerField::new('priority', 'priorité'),
            DateTimeField::new('updatedAt', 'Dernière mis à jour')->hideOnForm(),
            AssociationField::new('step', 'Etape liée à l\'image'),
            AssociationField::new('recipe', 'Recette liée à l\'image'),
        ];
    }
}
