<?php

namespace App\Entity;

use App\Repository\ServiceOperationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceOperationRepository::class)]
class ServiceOperation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?Service $service = null;

    #[ORM\Column(length: 255)]
    private ?string $uri = null;

    #[ORM\Column(length: 255)]
    private ?string $inside_key = null;

    #[ORM\Column(nullable: true)]
    private ?array $response_map = null;

    #[ORM\Column(nullable: true)]
    private ?array $default_data = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getInsideKey(): ?string
    {
        return $this->inside_key;
    }

    public function setInsideKey(string $inside_key): static
    {
        $this->inside_key = $inside_key;

        return $this;
    }

    public function getResponseMap(): ?array
    {
        return $this->response_map;
    }

    public function setResponseMap(?array $response_map): static
    {
        $this->response_map = $response_map;

        return $this;
    }

    public function getDefaultData(): ?array
    {
        return $this->default_data;
    }

    public function setDefaultData(?array $default_data): static
    {
        $this->default_data = $default_data;

        return $this;
    }
}
