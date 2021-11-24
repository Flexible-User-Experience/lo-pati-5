<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Enum\SortOrderTypeEnum;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function getTotalRecordsAmount(): int
    {
        try {
            $amount = $this->createQueryBuilder('a')
                ->select('COUNT(a.id) AS amount')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            $amount = -1;
        }

        return $amount;
    }

    public function getLast30DaysRecordsAmount(): int
    {
        try {
            $moment = new DateTime();
            $moment->sub(new DateInterval('P30D'));
            $amount = $this->createQueryBuilder('a')
                ->select('COUNT(a.id) AS amount')
                ->where('a.createdAt >= :moment')
                ->setParameter('moment', $moment)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            $amount = -1;
        }

        return $amount;
    }

    public function getEnabledSortedByName(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->where('a.active = :active')
            ->setParameter('active', true)
            ->orderBy('a.name', SortOrderTypeEnum::ASC);
    }
}
