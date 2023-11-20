<?php

namespace App\Dto\Api;

use App\Dto\Dto;

class AddressDto extends Dto
{
    protected string $id;
    protected string $province_name;
    protected string $department_name;
    protected string $locality_name;
    protected string $street_name;
    protected string $nomenclature;
    protected int $street_number;
    protected string $postal_code;
    protected ?string $reference;
    protected object $created_at;
    protected ?object $updated_at = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getProvinceName(): string
    {
        return $this->province_name;
    }

    public function setProvinceName(string $province_name): void
    {
        $this->province_name = $province_name;
    }

    public function getDepartmentName(): string
    {
        return $this->department_name;
    }

    public function setDepartmentName(string $department_name): void
    {
        $this->department_name = $department_name;
    }

    public function getLocalityName(): string
    {
        return $this->locality_name;
    }

    public function setLocalityName(string $locality_name): void
    {
        $this->locality_name = $locality_name;
    }

    public function getStreetName(): string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): void
    {
        $this->street_name = $street_name;
    }

    public function getNomenclature(): string
    {
        return $this->nomenclature;
    }

    public function setNomenclature(string $nomenclature): void
    {
        $this->nomenclature = $nomenclature;
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

    public function getCreatedAt(): object
    {
        return $this->created_at;
    }

    public function setCreatedAt(object $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?object
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?object $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}