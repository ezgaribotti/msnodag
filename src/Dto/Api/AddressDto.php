<?php

namespace App\Dto\Api;

use App\Dto\Dto;

class AddressDto extends Dto
{
    protected string $finger;
    protected string $created_at;
    protected ?string $updated_at = null;

    public function getFinger(): string
    {
        return $this->finger;
    }

    public function setFinger(string $finger): void
    {
        $this->finger = $finger;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}