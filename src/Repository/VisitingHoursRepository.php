<?php

namespace App\Repository;

use App\Entity\VisitingHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisitingHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitingHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitingHours[]    findAll()
 * @method VisitingHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class VisitingHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitingHours::class);
    }
}
