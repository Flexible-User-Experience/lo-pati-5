<?php

namespace App\Repository;

use App\Entity\NewsletterGroup;
use App\Entity\NewsletterUser;
use App\Enum\SortOrderTypeEnum;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method NewsletterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterUser[]    findAll()
 * @method NewsletterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class NewsletterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterUser::class);
    }

    public function getAllEnabled(): QueryBuilder
    {
        return $this->createQueryBuilder('nu')
            ->where('nu.active = :active')
            ->setParameter('active', true);
    }

    public function getAllSortedByEmail(string $sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('nu')->orderBy('nu.email', $sortOrder);
    }

    public function getEnabledByGroup(NewsletterGroup $group): QueryBuilder
    {
        return $this->getAllEnabled()
            ->join('nu.groups', 'g')
            ->andWhere('g.id = :id')
            ->setParameter('id', $group->getId());
    }

    public function getTotalRecordsAmount(): int
    {
        try {
            $amount = $this->createQueryBuilder('nu')
                ->select('COUNT(nu.id) AS amount')
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
            $amount = $this->createQueryBuilder('nu')
                ->select('COUNT(nu.id) AS amount')
                ->where('nu.createdAt >= :moment')
                ->setParameter('moment', $moment)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            $amount = -1;
        }

        return $amount;
    }
}
