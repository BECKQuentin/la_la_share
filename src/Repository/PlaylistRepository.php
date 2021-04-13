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

    public function findAllPlaylists($user)
    {
        return $this->createQueryBuilder('playlist')
            ->leftJoin('playlist.id_user', 'playlist_id_user')
            ->andWhere('playlist_id_user.id = :user')
            ->setParameter('user', $user)
            ->orderBy('playlist.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
