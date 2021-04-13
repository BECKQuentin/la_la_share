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

    public function findRecentMusics(int $limit = null)
    {
        return $this->findBy([], ['id' => 'DESC'], $limit);
    }
    
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySearch(Musics $musics, string $search): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.artist = :search')          
            ->setParameter('musics', $musics)
            ->setParameter('search', $search)            
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectDesc(Musics $musics): array
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.artist', 'DESC')       
            ->setParameter('musics', $musics)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectAsc(Musics $musics): array
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.artist', 'ASC')      
            ->setParameter('musics', $musics)
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function searchMusic(array $params ): array
    {
        $qb = $this->createQueryBuilder('m');

        if($search = $params['search_musics'] ?? null) {
            $qb->orWhere('m.artist LIKE :search')
                ->orWhere('m.title LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if($order = $params['search_select_musics'] ?? null) {
            if (in_array($order, ['asc', 'desc'])) {
                $qb->orderBy('m.artist', strtoupper($order));
            }
        }

        return $qb->getQuery()->getResult();   
    }
}
