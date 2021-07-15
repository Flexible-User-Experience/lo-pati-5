<?php

namespace App\Repository;

use App\Entity\Slideshow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
