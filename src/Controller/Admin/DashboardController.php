<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use App\Entity\NewsletterTemplate;
use App\Entity\Recipient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin_index')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(RecipientCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Communication & Marketing');
    }

    public function configureMenuItems(): \Iterator
    {
        yield MenuItem::linkToCrud('Newslettery', 'fas fa-envelope', Newsletter::class);
        yield MenuItem::linkToCrud('Szablony newsletterów', 'fas fa-newspaper', NewsletterTemplate::class);
        yield MenuItem::linkToCrud('Odbiorcy', 'fas fa-user', Recipient::class);
        yield MenuItem::linktoRoute('Stats', 'fa fa-chart-bar', 'app_admin_stats_board');
    }
}
