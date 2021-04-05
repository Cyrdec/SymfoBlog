<?php

namespace App\Repository;

use App\Entity\Edito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Edito|null find($id, $lockMode = null, $lockVersion = null)
 * @method Edito|null findOneBy(array $criteria, array $orderBy = null)
 * @method Edito[]    findAll()
 * @method Edito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edito::class);
    }

    // /**
    //  * @return Edito[] Returns an array of Edito objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * Retourne le dernier édito (celui qui a la date de publication la plus récente mais inférieur à la date du jour)
     * @param $max
     * @return array|null
     */
    public function findLastEdito(int $max = 1): ?array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.datePublication <= :date')->setParameter('date', date_create('now'))
            ->orderBy('e.datePublication', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
