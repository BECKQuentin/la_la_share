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

    // // /**
    // //  * @return Music[] Returns an array of Music objects
    // //  */    
    // public function musicsSearch(Musics $musics): array
    // {
    //     if(!empty($_POST['search_musics'])) {
    //         $search = $_POST['search_musics']; 
    //         $musics = $this->findBySearch($musics, $search);            
    //     }
    //     else if (!empty($_POST['search_select']) && $_POST['search_select'] == 1) {
           
    //         $musics = $this->findBySelectAsc($musics);
    //     }
    //     else if (!empty($_POST['search_select']) && $_POST['search_select'] == 2) {
            
    //         $musics = $this->findBySelectDesc($musics);            
    //     }
    //     else {
    //         $musics = $this->findAll($musics);
    //     }       
    //     return $musics; 
    // }

    // public function musicSearch(Musics $musics,  ) {

    //     if(!empty($params['search_musics'])) {            
    //         $search = $params['search_musics']; 
    //         $request = $this->findBySearch($musics, $search);            
    //     }
    //     else if (!empty($params['search_select_musics']) && $params['search_select_musics'] == 1) {
           
    //         $request = $this->findBySelectAsc($musics);
    //     }
    //     else if (!empty($params['search_select_musics']) && $params['search_select_musics'] == 2) {
            
    //         $request = $this->findBySelectDesc($musics);            
    //     }
    //     else {
    //         $request = $this->findAll();
    //     }   
    //     return $request;
    // }

}
