<?php

namespace App\Repository\Ventes;

use App\Entity\Ventes\DetailsCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailsCommande>
 *
 * @method DetailsCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsCommande[]    findAll()
 * @method DetailsCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsCommande::class);
    }

    public function save(DetailsCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetailsCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTotalCommande($commande)
    {
        return $this->createQueryBuilder('d')
            ->select('sum(d.totalht) as ht')
            ->where('d.commande = :commande')
            ->setParameter('commande',$commande)
            ->getQuery()
            ->getScalarResult();
    }
    public function rechercheProduit($currentCommande, $produit)
    {
        return $this->createQueryBuilder('d')
            ->where('d.produit = :produit AND d.commande = :commande')
            ->setParameter('produit',$produit)
            ->setParameter('commande',$currentCommande)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return DetailsCommande[] Returns an array of DetailsCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findByCommande($commande): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.commande = :commande')
            ->setParameter('commande', $commande)
            ->getQuery()
            ->getResult()
        ;
    }
}
