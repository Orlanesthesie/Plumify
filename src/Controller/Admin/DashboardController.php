<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Loan;
use App\Entity\User;
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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->render('admin/dashboard.html.twig', [
            'url' => $adminUrlGenerator->setController(BookCrudController::class)->generateUrl(),
        ]);
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(BookCrudController::class)->generateUrl());

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
            ->setTitle('<a href="/" style="text-decoration: none; color: inherit;">Plumify Admin</a>')
            ->setFaviconPath('/images/logos/icon.png')
            ->renderContentMaximized();
    }       

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Books', 'fas fa-book', Book::class),
            MenuItem::linkToCrud('Users', 'fas fa-users', User::class),
            MenuItem::linkToCrud('Authors', 'fas fa-pen-fancy', Author::class),
            MenuItem::linkToCrud('Categories', 'fas fa-table-list', Category::class),
            MenuItem::linkToCrud('Loans', 'fas fa-hand-holding-heart', Loan::class),
        ];
    }
}
