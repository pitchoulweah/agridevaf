<?php

namespace App\Controller\Blog;

use App\Entity\Blog\ArticleBlog;
use App\Entity\Blog\Comment;
use App\Form\Blog\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleBlogController extends AbstractController
{
    #[Route('/blog/produit/{slug}', name: 'article_show')]
    public function show(?ArticleBlog $article): Response
    {
        if (!$article){
            return $this->redirectToRoute('app_blog_home');
        }
        $comment = new Comment($article);

        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->render('blog/article/show.html.twig', [
            'produit' => $article,
            'commentForm'=>$commentForm->createView()
        ]);
    }
}
