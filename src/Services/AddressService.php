<?php

namespace App\Services;

use App\Dto\Api\AddressDto;
use App\Dto\Requests\AddressTransferDto;
use Doctrine\ORM\EntityManagerInterface;

class AddressService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}

    public function save(AddressTransferDto $data): AddressDto
    {
        dd($data);
    }
}