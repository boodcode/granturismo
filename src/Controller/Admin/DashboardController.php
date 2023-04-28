<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Filetype;
use App\Entity\Marque;
use App\Entity\Operation;
use App\Entity\Outil;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration | MOPAR - Mon Plan d\'Actions Commerciales');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Retour au site', 'fas fa-home', 'homepage');

        yield MenuItem::section('Utilsateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-map-marker-alt', User::class);

        yield MenuItem::section('Campagnes');
        yield MenuItem::linkToCrud('Opérations', 'fas fa-map-marker-alt', Operation::class);
        yield MenuItem::linkToCrud('Outils', 'fas fa-map-marker-alt', Outil::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-map-marker-alt', Categorie::class);

        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Marques', 'fas fa-map-marker-alt', Marque::class);


    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin')
            ->addWebpackEncoreEntry('adminJs');


    }


}
