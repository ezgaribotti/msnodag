<?php

namespace App\Dto\Requests;

use App\Dto\Dto;

class UpdateAddressTransferDto extends Dto
{
    protected int $street_number;
    protected string $postal_code;
    protected ?string $reference = null;

    public function getStreetNumber(): int
    {
        return $this->street_number;
    }

    public function setStreetNumber(int $street_number): void
    {
        $this->street_number = $street_number;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }
}