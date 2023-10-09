<?php

namespace App\Repository;

use App\Entity\CompagnyInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompagnyInfo>
 *
 * @method CompagnyInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompagnyInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompagnyInfo[]    findAll()
 * @method CompagnyInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompagnyInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompagnyInfo::class);
    }

//    /**
//     * @return CompagnyInfo[] Returns an array of CompagnyInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompagnyInfo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
