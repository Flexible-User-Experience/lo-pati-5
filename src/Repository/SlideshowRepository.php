<?php

namespace App\Repository;

use App\Entity\Slideshow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slideshow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slideshow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slideshow[]    findAll()
 * @method Slideshow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlideshowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slideshow::class);
    }

    public function getAllSortedByPosition($sortOrder = 'ASC'): QueryBuilder
    {
        return $this->createQueryBuilder('s')->orderBy('s.position', $sortOrder);
    }

    public function getAllSortedByPositionAndName($sortOrder = 'ASC'): QueryBuilder
    {
        return $this->getAllSortedByPosition($sortOrder)->addOrderBy('s.name', $sortOrder);
    }

    public function getEnabledSortedByPositionAndName($sortOrder = 'ASC'): QueryBuilder
    {
        return $this->getAllSortedByPositionAndName($sortOrder)
            ->where('s.active = :active')
            ->setParameter('active', true);
    }
}
