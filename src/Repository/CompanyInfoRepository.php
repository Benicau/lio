<?php

namespace App\Repository;

use App\Entity\CompanyInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyInfo>
 *
 * @method CompanyInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyInfo[]    findAll()
 * @method CompanyInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyInfo::class);
    }

//    /**
//     * @return CompanyInfo[] Returns an array of CompanyInfo objects
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

//    public function findOneBySomeField($value): ?CompanyInfo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
