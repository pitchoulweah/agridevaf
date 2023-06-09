<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Ventes\ProduitCrudController;
use App\Entity\Blog\ArticleBlog;
use App\Entity\Blog\Categorie;
use App\Entity\Blog\Comment;
use App\Entity\Blog\Media;
use App\Entity\Blog\Option;
use App\Entity\Pays;
use App\Entity\User;
use App\Entity\Ventes\CategorieProduit;
use App\Entity\Ventes\DetailsGrille;
use App\Entity\Ventes\GrilleTarifaire;
use App\Entity\Ventes\Produit;
use App\Entity\Ville;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private  AdminUrlGenerator $adminUrlGenerator)
    {

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(ProduitCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AGRIDEVAF');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Revenir au site web', 'fa fa-undo', 'portail');

        yield MenuItem::subMenu('Produits', 'fas fa-cart-shopping')->setSubItems([
            MenuItem::linkToCrud('Tous les produits','fas fa-cart-shopping',Produit::class),
            MenuItem::linkToCrud('Catégories produits','fas fa-list', CategorieProduit::class),
        ]);

        yield MenuItem::subMenu('Grilles Tarifaire','fas fa-euro')->setSubItems([
            MenuItem::linkToCrud('Ajouter','fas fa-plus', GrilleTarifaire::class),
            MenuItem::linkToCrud('Détails Grilles Tarifaire','fas fa-list', DetailsGrille::class)
        ]);

        yield MenuItem::subMenu('Actualités / Blog', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles','fas fa-newspaper', ArticleBlog::class),
            MenuItem::linkToCrud('Catégories','fas fa-list',Categorie::class),
            MenuItem::linkToCrud('Commentaires','fas fa-comment',Comment::class),
            MenuItem::linkToCrud('Media','fas fa-photo-video',Media::class)
        ]);
        yield MenuItem::subMenu('Confriguration', 'fas fa-tools')->setSubItems([
            MenuItem::linkToCrud('Utilisateurs','fas fa-user-friends',User::class),
            MenuItem::linkToCrud('Villes','fas fa-city',Ville::class),
            MenuItem::linkToCrud('Pays','fas fa-flag',Pays::class),
            MenuItem::linkToCrud('General','fas fa-cog',Option::class)
        ]);
    }
}
