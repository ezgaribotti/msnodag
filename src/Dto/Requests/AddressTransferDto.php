<?php

namespace App\Dto\Requests;

use App\Dto\Dto;

class AddressTransferDto extends Dto
{
    protected string $province_code;
    protected string $department_code;
    protected string $locality_code;
    protected string $street_code;
    protected int $street_number;
    protected string $postal_code;
    protected ?string $reference = null;

    public function getProvinceCode(): string
    {
        return $this->province_code;
    }

    public function setProvinceCode(string $province_code): void
    {
        $this->province_code = $province_code;
    }

    public function getDepartmentCode(): string
    {
        return $this->department_code;
    }

    public function setDepartmentCode(string $department_code): void
    {
        $this->department_code = $department_code;
    }

    public function getLocalityCode(): string
    {
        return $this->locality_code;
    }

    public function setLocalityCode(string $locality_code): void
    {
        $this->locality_code = $locality_code;
    }

    public function getStreetCode(): string
    {
        return $this->street_code;
    }

    public function setStreetCode(string $street_code): void
    {
        $this->street_code = $street_code;
    }

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