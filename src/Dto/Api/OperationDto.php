<?php

namespace App\Dto\Api;

use App\Dto\Dto;

class OperationDto extends Dto
{
    protected string $config_path;
    protected string $uri;
    protected string $inside_key;
    protected array $response_map;
    protected ?array $default_data;

    public function getConfigPath(): string
    {
        return $this->config_path;
    }

    public function setConfigPath(string $config_path): void
    {
        $this->config_path = $config_path;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getInsideKey(): string
    {
        return $this->inside_key;
    }

    public function setInsideKey(string $inside_key): void
    {
        $this->inside_key = $inside_key;
    }

    public function getResponseMap(): array
    {
        return $this->response_map;
    }

    public function setResponseMap(array $response_map): void
    {
        $this->response_map = $response_map;
    }

    public function getDefaultData(): ?array
    {
        return $this->default_data;
    }

    public function setDefaultData(?array $default_data): void
    {
        $this->default_data = $default_data;
    }
}