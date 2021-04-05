<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param $max|null
     * @return WebPage[] Returns an array of WebPage objects
     */
    public function header(int $max = 5): ?array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.header = :val')
            ->setParameter('val', true)
            ->orderBy('p.nom', 'ASC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * @param $max|null
     * @return WebPage[] Returns an array of WebPage objects
     */
    public function footer(int $max = 5): ?array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.footer = :val')
            ->setParameter('val', true)
            ->orderBy('p.nom', 'ASC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?WebPage
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
