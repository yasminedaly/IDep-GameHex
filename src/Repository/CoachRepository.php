<?php

namespace App\Repository;

use App\Entity\Coach;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query as ORM;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coach|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coach|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coach[]    findAll()
 * @method Coach[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoachRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coach::class);
    }

    /**
     * @param Coach $entity
     * @param bool $flush
     */
    public function add(Coach $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Coach $entity
     * @param bool $flush
     */
    public function remove(Coach $entity, bool $flush = true): void
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
        return $this->createQueryBuilder('c')
            ->where('tier LIKE :tier')
            ->orWhere(' rating LIKE :rating')
            ->orWhere('motto LIKE :motto')
            ->setParameters(
                ['tier' => $searchValue,
                    'rating'=>$searchValue,
                    'motto'=>$searchValue
                ])
            ->getQuery()
            ->getResult();
    }

    public function findRatingByCoach()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->SELECT('partial c.{id,rating}')
            ->From('App\Entity\Coach', 'c')
            ->getQuery();
        $query->setHint(ORM::HINT_FORCE_PARTIAL_LOAD, 1);
        return $query->getResult();
    }

    // /**
    //  * @return Coach[] Returns an array of Coach objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Coach
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

