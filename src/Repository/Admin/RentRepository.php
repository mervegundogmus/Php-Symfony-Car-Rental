<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Rent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rent[]    findAll()
 * @method Rent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rent::class);
    }

    // /**
    //  * @return Rent[] Returns an array of Rent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rent
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // *** LEFT JOIN WITH SQL ******
    public function getRents($status): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT r.*, c.title as cname, usr.name as uname FROM rent r
                    JOIN araba c  ON c.id = r.carid
                    JOIN user usr  ON usr.id = r.userid
                    WHERE r.status =:status
                    ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['status' => $status]);

        // return an array of arrays (i.e a raw data set)

        return $stmt->fetchAll();
    }

    // *** LEFT JOIN WITH SQL ******
    public function getRent($id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT r.*,c.title as cname, usr.name as uname FROM rent r
        JOIN araba c ON c.id = r.carid
        JOIN user usr  ON usr.id = r.userid
        WHERE r.id =:id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // return an array of arrays (i.e a raw data set)

        return $stmt->fetchAll();
    }

     // *** LEFT JOIN WITH SQL ******
     public function getUserRent($id): array
     {
         $conn = $this->getEntityManager()->getConnection();
         $sql = 'SELECT r.*,c.title as carname FROM rent r
                 JOIN araba c  ON c.id = r.carid
                 WHERE r.userid = :userid
                 ORDER BY r.id DESC';
         $stmt = $conn->prepare($sql);
         $stmt->execute(['userid'=>$id]);
 
         // return an array of arrays (i.e a raw data set)
 
         return $stmt->fetchAll();
     }
 
}
