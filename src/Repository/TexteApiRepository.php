<?php

namespace App\Repository;

use App\Entity\TexteApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TexteApi>
 *
 * @method TexteApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method TexteApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method TexteApi[]    findAll()
 * @method TexteApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TexteApiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TexteApi::class);
    }

//    /**
//     * @return TexteApi[] Returns an array of TexteApi objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TexteApi
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
