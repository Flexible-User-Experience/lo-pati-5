<?php

namespace App\Repository;

use App\Entity\MenuLevel2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel2|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel2|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel2[]    findAll()
 * @method MenuLevel2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuLevel2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel2::class);
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
