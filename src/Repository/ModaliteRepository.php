<?php

namespace App\Repository;

use App\Entity\Modalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Modalite>
 *
 * @method Modalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modalite[]    findAll()
 * @method Modalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modalite::class);
    }

//    /**
//     * @return Modalite[] Returns an array of Modalite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Modalite
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
