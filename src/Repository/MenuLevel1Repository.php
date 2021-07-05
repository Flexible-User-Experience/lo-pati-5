<?php

namespace App\Repository;

use App\Entity\MenuLevel1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel1|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel1|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel1[]    findAll()
 * @method MenuLevel1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuLevel1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel1::class);
    }

    public function getAllSortedByPosition($sortOrder = 'ASC'): QueryBuilder
    {
        return $this->createQueryBuilder('m')->orderBy('m.position', $sortOrder);
    }
}
