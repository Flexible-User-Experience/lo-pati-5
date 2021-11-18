<?php

namespace App\Repository;

use App\Entity\MenuLevel1;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel1|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel1|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel1[]    findAll()
 * @method MenuLevel1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuLevel1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel1::class);
    }

    public function getAllSortedByPosition($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('m')->orderBy('m.position', $sortOrder);
    }

    public function getAllSortedByPositionAndName($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getAllSortedByPosition($sortOrder)->addOrderBy('m.name', $sortOrder);
    }

    public function getEnabledSortedByPosition($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getAllSortedByPosition($sortOrder)->where('m.active = :active')->setParameter('active', true);
    }

    public function getEnabledSortedByPositionAndName($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getEnabledSortedByPosition($sortOrder)->addOrderBy('m.name', $sortOrder);
    }
}
