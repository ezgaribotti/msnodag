<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class DepartmentService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}
}