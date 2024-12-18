<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Ingredient;
use App\Entity\IngredientGroup;
use App\Entity\Recipe;
use App\Entity\RecipeHasIngredient;
use App\Entity\Source;
use App\Entity\Step;
use App\Entity\Tag;
use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Recette');
    }

    public function configureCrud(): Crud
    {
        $crud = parent::configureCrud();

        $crud
            ->renderContentMaximized()
            ->showEntityActionsInlined();

        return $crud;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Recettes', 'fas fa-utensils', Recipe::class);

        yield MenuItem::section('Gestion des données');
        yield MenuItem::linkToCrud('Tags', 'fas fa-hashtag', Tag::class);
        yield MenuItem::linkToCrud('Unités', 'fas fa-balance-scale', Unit::class);
        yield MenuItem::linkToCrud('Sources', 'fa fa-lightbulb', Source::class);
        yield MenuItem::linkToCrud('Ingredients', 'fas fa-carrot', Ingredient::class);

        yield MenuItem::section('Gestion des Sous données');
        yield MenuItem::linkToCrud('Etapes', 'fas fa-forward-step', Step::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-images', Image::class);
        yield MenuItem::linkToCrud('Groupes d\'ingrédients', 'fas fa-layer-group', IngredientGroup::class);
        yield MenuItem::linkToCrud('Ingrédients de recettes', 'fas fa-utensils', RecipeHasIngredient::class);
    }
}
