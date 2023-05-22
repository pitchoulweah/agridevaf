<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Àrticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Àrticle>
 *
 * @method Àrticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Àrticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Àrticle[]    findAll()
 * @method Àrticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ÀrticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Àrticle::class);
    }

    public function save(Àrticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Àrticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Àrticle[] Returns an array of Àrticle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('�')
//            ->andWhere('�.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('�.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Àrticle
//    {
//        return $this->createQueryBuilder('�')
//            ->andWhere('�.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
