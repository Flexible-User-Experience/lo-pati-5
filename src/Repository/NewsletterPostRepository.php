<?php

namespace App\Repository;

use App\Entity\NewsletterPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterPost[]    findAll()
 * @method NewsletterPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class NewsletterPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterPost::class);
    }
}
