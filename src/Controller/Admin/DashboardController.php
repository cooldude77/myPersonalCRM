<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Product\ProductController;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ProductController::class)->generateUrl());

        /// return parent::index();

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
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MyPersonalCRM');


    }


    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Master Data'),
            MenuItem::linkToCrud('Category', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Product', 'fa fa-tags', Product::class),
            MenuItem::linkToCrud('ProductType', 'fa fa-tags', ProductType::class),
            // MenuItem::linkToCrud('Customer', 'fa fa-tags', Customer::class),
            //MenuItem::linkToCrud('Product', 'fa fa-tags', PriceBaseProduct::class),

            MenuItem::section('Users'),

        ];
    }
}
