<?php

namespace App\Dto\Api;

use App\Dto\Dto;

class StreetDto extends Dto
{
    protected int $id;
    protected string $name;
    protected string $external_code;
    protected string $category;
    protected string $nomenclature;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getExternalCode(): string
    {
        return $this->external_code;
    }

    public function setExternalCode(string $external_code): void
    {
        $this->external_code = $external_code;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getNomenclature(): string
    {
        return $this->nomenclature;
    }

    public function setNomenclature(string $nomenclature): void
    {
        $this->nomenclature = $nomenclature;
    }
}