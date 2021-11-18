<?php

namespace App\Repository;

use App\Entity\ConfigFooterInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfigFooterInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigFooterInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigFooterInformation[]    findAll()
 * @method ConfigFooterInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ConfigFooterInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigFooterInformation::class);
    }
}
