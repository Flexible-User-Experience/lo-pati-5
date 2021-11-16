<?php

namespace App\Repository;

use App\Entity\ConfigCalendarWorkingDay;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfigCalendarWorkingDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigCalendarWorkingDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigCalendarWorkingDay[]    findAll()
 * @method ConfigCalendarWorkingDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ConfigCalendarWorkingDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigCalendarWorkingDay::class);
    }

    public function getActiveWorkingDaysSortedByNumber(): array
    {
        return $this->createQueryBuilder('ccwd')
            ->where('ccwd.active = :active')
            ->setParameter('active', true)
            ->orderBy('ccwd.workingDayNumber', SortOrderTypeEnum::ASC)
            ->getQuery()
            ->getResult();
    }
}
