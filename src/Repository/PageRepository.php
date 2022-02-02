<?php

namespace App\Repository;

use App\Entity\AbstractBase;
use App\Entity\Archive;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Enum\SortOrderTypeEnum;
use DateInterval;
use DateTime;
use DateTimeImmutable;
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
final class PageRepository extends ServiceEntityRepository
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

    public function getAllSortedByPublishDate(string $sortOrder = SortOrderTypeEnum::DESC): QueryBuilder
    {
        return $this->createQueryBuilder('p')->orderBy('p.publishDate', $sortOrder);
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

    public function getActiveItemsFromDayAndMonthAndYear(string $day, string $month, string $year): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.startDate <= :moment AND p.endDate >= :moment')
            ->setParameter('active', true)
            ->setParameter('moment', date(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, strtotime($year.'-'.$month.'-'.$day)))
            ->orderBy('p.endDate', SortOrderTypeEnum::ASC)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getActiveItemsFromMonthAndYear(int $month, int $year): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.startDate >= :begin AND p.startDate <= :end OR p.endDate >= :begin AND p.endDate <= :end OR p.startDate <= :begin AND p.endDate >= :end')
            ->andWhere('p.menuLevel1 IS NOT NULL')
            ->setParameter('active', true)
            ->setParameter('begin', date(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, mktime(0, 0, 0, $month, 1, $year)))
            ->setParameter('end', date('Y-m-t', mktime(0, 0, 0, $month, 28, $year)))
            ->orderBy('p.startDate', SortOrderTypeEnum::ASC)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getActiveItemsFromArchive(Archive $archive): QueryBuilder
    {
        $today = new DateTimeImmutable();

        return $this->createQueryBuilder('p')
            ->where('p.expirationDate <= :today')
            ->andWhere('p.publishDate BETWEEN :begin and :end')
            ->andWhere('p.active = :active')
            ->setParameter('today', $today->format(AbstractBase::DATABASE_IMPORT_DATE_FORMAT))
            ->setParameter('begin', date(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, mktime(0, 0, 0, 1, 1, $archive->getYear())))
            ->setParameter('end', date(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, mktime(0, 0, 0, 12, 31, $archive->getYear())))
            ->setParameter('active', true)
            ->orderBy('p.startDate', SortOrderTypeEnum::DESC)
        ;
    }

    public function getActiveItemsFromMenuLevel2SortedByPublishDate(MenuLevel2 $menuLevel2): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.menuLevel2 = :menu')
            ->setParameter('menu', $menuLevel2)
            ->setParameter('active', true)
            ->orderBy('p.publishDate', SortOrderTypeEnum::DESC)
        ;
    }

    public function getActiveItemsRelatedByMenuLevel2OrMenuLeve1SortedByPublishDate(Page $page): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.id != :page')
            ->andWhere('p.menuLevel1 = :menu')
            ->setParameter('page', $page->getId())
            ->setParameter('menu', $page->getMenuLevel1())
            ->setParameter('active', true)
            ->orderBy('p.publishDate', SortOrderTypeEnum::DESC)
            ->setMaxResults(3)
        ;
        if ($page->getMenuLevel2()) {
            $qb
                ->andWhere('p.menuLevel2 = :submenu')
                ->setParameter('submenu', $page->getMenuLevel2())
            ;
        }

        return $qb;
    }
}
