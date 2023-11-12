<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class StreetService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}
}