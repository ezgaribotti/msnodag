<?php

namespace App\Dto\Requests;

use App\Dto\Dto;

class DepartmentTransferDto extends Dto
{
    protected string $name;
    protected string $province_code;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getProvinceCode(): string
    {
        return $this->province_code;
    }

    public function setProvinceCode(string $province_code): void
    {
        $this->province_code = $province_code;
    }
}