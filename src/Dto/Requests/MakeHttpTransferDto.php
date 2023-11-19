<?php

namespace App\Dto\Requests;

use App\Dto\Api\OperationDto;
use App\Dto\Dto;

class MakeHttpTransferDto extends Dto
{
    protected array $data;
    protected string $dto;
    protected OperationDto $operation;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getDto(): string
    {
        return $this->dto;
    }

    public function setDto(string $dto): void
    {
        $this->dto = $dto;
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