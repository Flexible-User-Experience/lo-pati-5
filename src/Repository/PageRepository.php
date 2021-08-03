<?php

namespace App\Repository;

use App\Entity\AbstractBase;
use App\Entity\Page;
use App\Enum\SortOrderTypeEnum;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByDateAndSlug(string $date, string $page): ?Page
    {
        $publishDate = DateTime::createFromFormat(AbstractBase::DATAGRID_TYPE_DATE_FORMAT, $date);

        return $this->createQueryBuilder('p')
            ->where('p.slug = :page')
            ->andWhere('p.publishDate = :date')
            ->setParameter('page', $page)
            ->setParameter('date', $publishDate->format(AbstractBase::DATABASE_IMPORT_DATE_FORMAT))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getHomepageHighlighted(string $sortOrder = SortOrderTypeEnum::DESC): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.isFrontCover = :cover')
            ->andWhere('p.menuLevel2 IS NOT NULL')
            ->setParameter('active', true)
            ->setParameter('cover', true)
            ->orderBy('p.publishDate', $sortOrder);
    }

    public function getAllSortedByName(string $sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('p')->orderBy('p.name', $sortOrder);
    }

    public function getTotalRecordsAmount(): int
    {
        try {
            $amount = $this->createQueryBuilder('p')
                ->select('COUNT(p.id) AS amount')
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
            $amount = $this->createQueryBuilder('p')
                ->select('COUNT(p.id) AS amount')
                ->where('p.createdAt >= :moment')
                ->setParameter('moment', $moment)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Exception $e) {
            $amount = -1;
        }

        return $amount;
    }
}
