<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Playlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[]    findAll()
 * @method Playlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    // /**
    //  * @return Playlist[] Returns an array of Playlist objects
    //  */

    public function findAllPlaylists($userId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user_id = :user_id')
            ->setParameter('user_id', $userId)
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
