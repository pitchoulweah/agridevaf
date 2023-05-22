<?php

namespace App\Controller\Ventes;

use App\Entity\Blog\ArticleBlog;
use App\Entity\Blog\Comment;
use App\Entity\Ventes\Produit;
use App\Form\Blog\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{

    #[Route('/produit/{slug}', name: 'produit_show')]
    public function show(?Produit $produit): Response
    {
        if (!$produit){
            return $this->redirectToRoute('boutique');
        }

        return $this->render('ventes/produit/index.html.twig', [
            'produit' => $produit
        ]);
    }
}
