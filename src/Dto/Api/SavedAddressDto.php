<?php

namespace App\Dto\Api;

use App\Dto\Dto;

class SavedAddressDto extends Dto
{
    protected string $id;
    protected object $created_at;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): object
    {
        return $this->created_at;
    }

    public function setCreatedAt(object $created_at): void
    {
        $this->created_at = $created_at;
    }
}