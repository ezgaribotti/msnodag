<?php

namespace App\Repository;

use App\Entity\ServiceOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceOperation>
 *
 * @method ServiceOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceOperation[]    findAll()
 * @method ServiceOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceOperation::class);
    }
}
