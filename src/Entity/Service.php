<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $base_uri = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $config_path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseUri(): ?string
    {
        return $this->base_uri;
    }

    public function setBaseUri(string $base_uri): static
    {
        $this->base_uri = $base_uri;

        return $this;
    }

    public function getConfigPath(): ?string
    {
        return $this->config_path;
    }

    public function setConfigPath(?string $config_path): static
    {
        $this->config_path = $config_path;

        return $this;
    }
}
