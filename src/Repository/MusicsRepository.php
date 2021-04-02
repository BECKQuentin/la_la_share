<?php

namespace App\Repository;

use App\Entity\Musics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Musics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musics[]    findAll()
 * @method Musics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musics::class);
    }

    // /**
    //  * @return Musics[] Returns an array of Musics objects
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
    public function findOneBySomeField($value): ?Musics
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
