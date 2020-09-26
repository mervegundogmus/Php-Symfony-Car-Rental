<?php

namespace App\Repository;

use App\Entity\Araba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Araba|null find($id, $lockMode = null, $lockVersion = null)
 * @method Araba|null findOneBy(array $criteria, array $orderBy = null)
 * @method Araba[]    findAll()
 * @method Araba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArabaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Araba::class);
    }

    // /**
    //  * @return Araba[] Returns an array of Araba objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Araba
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
