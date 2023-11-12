<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class ProvinceService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}
}