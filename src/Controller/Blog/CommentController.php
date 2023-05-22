<?php

namespace App\Controller\Blog;

use App\Entity\Blog\ArticleBlog;
use App\Entity\Blog\Comment;
use App\Repository\Blog\ArticleBlogRepository;
use App\Repository\Blog\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/blog/ajax/comment', name: 'comment_add')]
    public function index(Request $request,
                          ArticleBlogRepository $articleRepository,
                          EntityManagerInterface $manager,
                          CommentRepository $commentRepository
    ): Response
    {
        $commentData = $request->request->all('comment');
        if(!$this->isCsrfTokenValid('comment_add',$commentData['_token'])){
            return $this->json([
                'code'=>'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }
        $article = $articleRepository->findOneBy(['id'=>$commentData['produit']]);

        if (!$article){
            return $this->json([
                'code'=>'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment($article);
        $comment->setContent($commentData['content']);
        $comment->setUtilisateur($this->getUser());
        $comment->setCreatedAt(new \DateTime());

        $manager->persist($comment);
        $manager->flush($comment);

        $html = $this->renderView('blog/comment/index.html.twig',['comment'=>$comment]);
        return $this->json([
            'code'=>'COMMENT_USER_SUCCESSFULLY',
            'message'=>$html,
            'number_comments'=>$commentRepository->count(['produit'=>$article])
        ], Response::HTTP_ACCEPTED);
    }
}
