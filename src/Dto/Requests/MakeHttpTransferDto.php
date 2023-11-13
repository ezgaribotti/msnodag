<?php

namespace App\Dto\Requests;

use App\Dto\Api\OperationDto;
use App\Dto\Dto;

class MakeHttpTransferDto extends Dto
{
    protected array $data;
    protected string $className;
    protected OperationDto $operation;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    public function getOperation(): OperationDto
    {
        return $this->operation;
    }

    public function setOperation(OperationDto $operation): void
    {
        $this->operation = $operation;
    }
}