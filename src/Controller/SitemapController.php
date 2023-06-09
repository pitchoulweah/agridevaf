<?php

namespace App\Controller;

use App\Repository\Blog\ArticleBlogRepository;
use App\Repository\Ventes\CategorieProduitRepository;
use App\Repository\Ventes\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(
        Request $request,
        ProduitRepository $produitRepository,
        ArticleBlogRepository $articleRepository,
        CategorieProduitRepository $categorieProduitRepository,

    ): Response
    {
        $hostname = $request->getSchemeAndHttpHost();


        $urls = [];
        $urls[] = ['loc'=>$this->generateUrl('app_portail')];
        $urls[] = ['loc'=>$this->generateUrl('app_about')];
        $urls[] = ['loc'=>$this->generateUrl('boutique')];

        foreach ($produitRepository->findAll() as $produit){
            $urls[] = [
                'loc'=>$this->generateUrl('produit_show',['slug'=>$produit->getSlug()])
            ];
        }

        foreach ($articleRepository->findAll() as $article){
            $urls[] = [
                'loc'=>$this->generateUrl('article_show',['slug'=>$article->getSlug()]),
                'lastmod'=>$article->getCreatedAt()->format('Y-m-d')
            ];
        }

        foreach ($categorieProduitRepository->findAll() as $categorieProduit){
            $urls[] = [
                'loc'=>$this->generateUrl('app_categpories_produits')
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig',[
                'urls'=>$urls,
                'hostname'=>$hostname,
            ]),200
        );
        //dd($response);
        $response->headers->set('Content-type','text/xml');

        return $response;
    }
}
