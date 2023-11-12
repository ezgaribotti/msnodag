<?php

namespace App\Dto\Requests;

use App\Dto\Dto;

class LocalityTransferDto extends Dto
{
    protected string $name;
    protected string $department_code;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDepartmentCode(): string
    {
        return $this->department_code;
    }

    public function setDepartmentCode(string $department_code): void
    {
        $this->department_code = $department_code;
    }
}