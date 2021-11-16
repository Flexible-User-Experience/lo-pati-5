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

    public function getActiveItemsFromMonthAndYear(int $month, int $year): array
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT n FROM BlogBundle:Pagina n
                            WHERE n.actiu = 1
                            AND (n.startDate>=:inici AND n.startDate<=:fi OR n.endDate>=:inici AND n.endDate<=:fi OR n.startDate<=:inici AND n.endDate>=:fi)
                            AND n.categoria IS NOT NULL
                            ORDER BY n.startDate ASC');
        $query->setParameter('inici', date('Y-m-d', mktime(0, 0, 0, $mes, 1, $any)));
        $query->setParameter('fi', date('Y-m-t', mktime(0, 0, 0, $mes, 28, $any)));    // la opcion -t devuelve la cantidad de dias que tiene el mes dado

        return $query->getResult();
    }
}
