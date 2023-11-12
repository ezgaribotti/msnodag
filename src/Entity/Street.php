<?php

namespace App\Entity;

use App\Repository\StreetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StreetRepository::class)]
class Street
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $external_code = null;

    #[ORM\ManyToOne]
    private ?Province $province = null;

    #[ORM\ManyToOne]
    private ?Department $department = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $nomenclature = null;

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

    public function getExternalCode(): ?string
    {
        return $this->external_code;
    }

    public function setExternalCode(string $external_code): static
    {
        $this->external_code = $external_code;

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getNomenclature(): ?string
    {
        return $this->nomenclature;
    }

    public function setNomenclature(string $nomenclature): static
    {
        $this->nomenclature = $nomenclature;

        return $this;
    }
}
