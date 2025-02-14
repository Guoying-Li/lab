<?php

namespace App\Repository;

use App\Entity\Objet;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Objet>
 *
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objet::class);
    }


    public function getAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT o
                FROM App\Entity\Objet o
                ORDER BY o.titre ASC'
        );
        return $query->execute();
    }

    // Find/search objets by title
    public function findObjetsByTitle(string $query)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('o.titre', ':query'),
                        $qb->expr()->like('o.description', ':query'),
                    ),
                    $qb->expr()->isNotNull('o.id')
                )
            )
            ->setParameter('query', '%' . $query . '%');
        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les objets en fonction du formulaire
     * @return void 
     */
    public function search($categorie = null)
    {
        $query = $this->createQueryBuilder('o');
        $query->where('o.active = 1');
        if ($categorie != null) {
            $query->leftJoin('o.categories', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        return $query->getQuery()->getResult();
    }

    public function findByCategorie(Categorie $categorie): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.categories', 'cat') 
            ->where('cat.id = :categorieId')
            ->setParameter('categorieId', $categorie->getId())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Objet[] Returns an array of Objet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Objet
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
