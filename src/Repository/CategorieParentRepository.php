<?php

namespace App\Repository;

use App\Entity\CategorieParent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieParent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieParent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieParent[]    findAll()
 * @method CategorieParent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieParentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieParent::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CategorieParent $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CategorieParent $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CategorieParent[] Returns an array of CategorieParent objects
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
    public function findOneBySomeField($value): ?CategorieParent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAllCategories()
    {
        return $this->createQueryBuilder('u')
            ->getQuery()
            ->getArrayResult()
        ;
    }
    public function getOneCategorieParent($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id='.$id)
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
