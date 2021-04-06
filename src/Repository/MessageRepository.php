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
 
    public function findConversationBetween($sender, $receiver)
    {
        return $this->createQueryBuilder('m')
            ->orWhere('m.sender_id = :sender AND m.receiver_id = :receiver')            
            ->orWhere('m.sender_id = :receiver AND m.receiver_id = :sender')            
            ->setParameter('sender', $sender)
            ->setParameter('receiver', $receiver)
            ->orderBy('m.send_at', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }   
    
}
