<?php

namespace App\Repository;

use App\Entity\MenuLevel2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel2|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel2|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel2[]    findAll()
 * @method MenuLevel2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuLevel2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel2::class);
    }
}
