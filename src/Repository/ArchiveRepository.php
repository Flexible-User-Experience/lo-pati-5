<?php

namespace App\Repository;

use App\Entity\Archive;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archive::class);
    }

    public function getEnabledSortedByYear(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->where('a.active = :active')
            ->setParameter('active', true)
            ->orderBy('a.year', SortOrderTypeEnum::DESC)
        ;
    }
}
