<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }
 
    public function findConversationBetween($viewer, $interlocutor)
    {
        return $this->createQueryBuilder('m')
            ->where('m.sender_id = :viewer')
            ->andWhere('m.receiver_id = :interlocutor')
            ->andWhere('m.sender_id = :interlocutor')
            ->andWhere('m.receiver_id = :viewer')
            ->setParameter('viewer', $viewer)
            ->setParameter('interlocutor', $interlocutor)
            ->orderBy('m.send_at', 'DESC')
            ->limit('50')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
