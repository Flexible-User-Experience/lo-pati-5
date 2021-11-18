<?php

namespace App\Repository;

use App\Entity\NewsletterGroup;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterGroup[]    findAll()
 * @method NewsletterGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class NewsletterGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterGroup::class);
    }

    public function getAllSortedByName(string $sortOrder = SortOrderTypeEnum::ASC): QueryBuilder
    {
        return $this->createQueryBuilder('ng')->orderBy('ng.name', $sortOrder);
    }
}
