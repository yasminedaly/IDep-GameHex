<?php

namespace App\Repository;

use App\Entity\MyPropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyPropertySearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyPropertySearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyPropertySearch[]    findAll()
 * @method MyPropertySearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyPropertySearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyPropertySearch::class);
    }

    /**
     * @param MyPropertySearch $entity
     * @param bool $flush
     */
    public function add(MyPropertySearch $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param MyPropertySearch $entity
     * @param bool $flush
     */
    public function remove(MyPropertySearch $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return MyPropertySearch[] Returns an array of MyPropertySearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyPropertySearch
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
