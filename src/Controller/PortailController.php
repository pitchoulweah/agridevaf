<?php

namespace App\Controller;

use App\Entity\Blog\ArticleBlog;
use App\Repository\Blog\ArticleBlogRepository;
use App\Repository\Blog\CategorieRepository;
use App\Repository\Ventes\CategorieProduitRepository;
use App\Repository\Ventes\ProduitRepository;
use App\Services\OptionsService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortailController extends AbstractController
{
    #[Route('/', name: 'app_portail')]
    public function index(
        ProduitRepository $repository,
        Request                                $request,
        ManagerRegistry                        $manager,
        ArticleBlogRepository $articleRepository,
        ArticleBlogRepository                      $uniqueArticle,
        CategorieRepository                    $categorieRepository,
        OptionsService                         $optionsService,
        CategorieProduitRepository $categorieProduitRepository,
        int                                    $idArticle = 0
    ): Response
    {
        $lastArticle = new ArticleBlog();

        $idArticle = $uniqueArticle->findLastArticleBlogs();

        $articles =  $articleRepository->findAll();
        $liste_categories = $categorieProduitRepository->findAll();

//dd($idArticle);
        //dd($manager->getRepository(Article::class)->find($idArticle[1]));
        $lastArticle = $manager->getRepository(ArticleBlog::class)->find($idArticle[1]);
        //dd($lastArticle);
        return $this->render('portail/index.html.twig', [
            'produits'=>$repository->findAll(),
            'articles_blog'=>$articles,
            'categories'=>$categorieRepository->findAll(),
            'last_articles'=>$lastArticle,
            'categories_pdt' => $liste_categories
        ]);
    }
}
