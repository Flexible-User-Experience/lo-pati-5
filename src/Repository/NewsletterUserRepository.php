<?php

namespace App\Repository;

use App\Entity\NewsletterUser;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method NewsletterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterUser[]    findAll()
 * @method NewsletterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterUser::class);
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
