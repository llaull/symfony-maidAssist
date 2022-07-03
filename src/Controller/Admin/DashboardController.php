<?php

namespace App\Controller\Admin;

use App\Entity\Intervention;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // return parent::index();
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Maid assist admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('home','fas fa-house-user','app_intervention_index');
        
        yield MenuItem::section('User');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create User', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show User', 'fas fa-eye', User::class)
        ]);

        yield MenuItem::section('Interventions');

        yield MenuItem::linkToCrud('Show All interventions', 'fas fa-table', Intervention::class);
    }
}
