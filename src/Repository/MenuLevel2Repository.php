<?php

namespace App\Repository;

use App\Entity\MenuLevel2;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel2|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel2|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel2[]    findAll()
 * @method MenuLevel2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuLevel2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel2::class);
    }

    public function getAllSortedByPosition($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('sm')->orderBy('sm.position', $sortOrder);
    }

    public function getAllSortedByPositionAndName($sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->getAllSortedByPosition($sortOrder)->addOrderBy('sm.name', $sortOrder);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByMenuAndSubmenuSlugs(string $menu, string $submenu): ?MenuLevel2
    {
        return $this->createQueryBuilder('sm')
            ->join('sm.menuLevel1', 'm')
            ->where('m.slug = :menu')
            ->andWhere('sm.slug = :submenu')
            ->setParameter('menu', $menu)
            ->setParameter('submenu', $submenu)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
