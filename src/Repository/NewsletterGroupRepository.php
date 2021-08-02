<?php

namespace App\Repository;

use App\Entity\NewsletterGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterGroup[]    findAll()
 * @method NewsletterGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterGroup::class);
    }
}
