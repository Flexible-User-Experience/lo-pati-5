<?php

namespace App\Repository;

use App\Entity\PageImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageImage[]    findAll()
 * @method PageImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PageImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageImage::class);
    }
}
