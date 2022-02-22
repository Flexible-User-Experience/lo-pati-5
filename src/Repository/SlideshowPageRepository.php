<?php

namespace App\Repository;

use App\Entity\SlideshowPage;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlideshowPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlideshowPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlideshowPage[]    findAll()
 * @method SlideshowPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SlideshowPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlideshowPage::class);
    }

    public function getAllSortedByPosition($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('s')->orderBy('s.position', $sortOrder);
    }

    public function getAllSortedByPositionAndName($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getAllSortedByPosition($sortOrder)->addOrderBy('s.name', $sortOrder);
    }

    public function getEnabledSortedByPositionAndName($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getAllSortedByPositionAndName($sortOrder)
            ->where('s.active = :active')
            ->setParameter('active', true);
    }
}
