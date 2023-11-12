<?php

namespace App\Repository;

use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Street>
 *
 * @method Street|null find($id, $lockMode = null, $lockVersion = null)
 * @method Street|null findOneBy(array $criteria, array $orderBy = null)
 * @method Street[]    findAll()
 * @method Street[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Street::class);
    }
}
