<?php

namespace App\Repository;

use App\Entity\VisitingHours;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisitingHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitingHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitingHours[]    findAll()
 * @method VisitingHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class VisitingHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitingHours::class);
    }

    public function getVisitingHoursQB(): QueryBuilder
    {
        return $this->createQueryBuilder('vh')
            ->orderBy('vh.createdAt', SortOrderTypeEnum::DESC)
            ->setMaxResults(1)
        ;
    }

    public function getVisitingHoursQ(): Query
    {
        return $this->getVisitingHoursQB()->getQuery();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getVisitingHours(): ?VisitingHours
    {
        return $this->getVisitingHoursQ()->getOneOrNullResult();
    }
}
