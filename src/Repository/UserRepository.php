<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findAllAdmin()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_ADMIN%')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findAllMember(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.verifiedEmail LIKE :verified_email')
            ->andWhere('u.id != :user')
            ->setParameter('verified_email', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySearch(User $user, $search): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.verifiedEmail LIKE :verified_email')
            ->andWhere('u.id != :user')
            ->andWhere('u.pseudo = :search')
            ->setParameter('verified_email', 1)            
            ->setParameter('user', $user)
            ->setParameter('search', $search)            
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectDesc(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.verifiedEmail LIKE :verified_email')
            ->andWhere('u.id != :user')
            ->orderBy('u.pseudo', 'DESC')
            ->setParameter('verified_email', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */    
    public function findBySelectAsc(User $user): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.verifiedEmail LIKE :verified_email')
            ->andWhere('u.id != :user')
            ->orderBy('u.pseudo', 'ASC')
            ->setParameter('verified_email', 1)            
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
