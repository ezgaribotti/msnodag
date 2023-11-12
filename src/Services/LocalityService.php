<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class LocalityService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}
}