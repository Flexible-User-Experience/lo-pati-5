<?php

namespace App\Repository;

use App\Entity\NewsletterUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterUser[]    findAll()
 * @method NewsletterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterUser::class);
    }
}
