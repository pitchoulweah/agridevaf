<?php

namespace App\Controller\Ventes;

use App\Entity\Ventes\Produit;
use App\Repository\Ventes\CategorieProduitRepository;
use App\Repository\Ventes\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieProduitController extends AbstractController
{
    #[Route('/categories_pdt', name: 'app_categpories_produits')]
    public function index(CategorieProduitRepository $repository): Response
    {
        $liste_categories = $repository->findAll();
        //dd($liste_categories);
        return $this->render('menu.html.twig', [
            'categories_pdt' => $liste_categories
        ]);
    }

    #[Route('/la-boutique', name: 'boutique')]
    public function shop()
    {
        return $this->render('boutique/shop.html.twig');
    }
}
