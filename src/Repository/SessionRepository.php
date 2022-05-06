<?php

namespace App\Repository;

use App\Entity\Coach;
use App\Entity\Session;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Session::class);
        $this->security = $security;
    }

    /**
     * @param Session $entity
     * @param bool $flush
     */
    public function add(Session $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Session $entity
     * @param bool $flush
     */
    public function remove(Session $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    //  * @return Session[] Returns an array of Session objects
    //  */

    public function findByMultiple($searchValue)
    {
        return $this->createQueryBuilder('s')
            ->join('s.coach', 'c')
            ->addSelect('c')
            ->where('s.title LIKE :title')
            ->orWhere('s.description LIKE :desc')
            ->orWhere('s.rating LIKE :rate')
            ->orWhere('c.tier LIKE :tier')
            ->setParameters(
                ['title' => $searchValue, 'tier'=>$searchValue,
                    'desc'=>$searchValue, 'rate'=>$searchValue
                ])
            ->getQuery()
            ->getResult();
    }

    public function findSessionByUser(User $user)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM App:Session s '.
                'WHERE s.user = :id'
            )->setParameter('id', $user->getId());

        return $query->getResult();
    }

    /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    public function findByTitle($title)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title LIKE :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
