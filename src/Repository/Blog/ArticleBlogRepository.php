<?php

namespace App\Repository\Blog;

use App\Entity\Blog\ArticleBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleBlog>
 *
 * @method ArticleBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleBlog[]    findAll()
 * @method ArticleBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleBlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleBlog::class);
    }

    public function save(ArticleBlog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArticleBlog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ArticleBlog[] Returns an array of ArticleBlog objects
     */
    public function findAllArticleBlogs(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLastArticleBlogs()
    {
        return $this->createQueryBuilder('a')
            ->select('max(a.id)')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function derniersArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?ArticleBlog
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
