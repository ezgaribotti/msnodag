<?php

namespace App\Services;

use App\Dto\Api\AddressDto;
use App\Dto\Requests\AddressTransferDto;
use App\Entity\Address;
use App\Entity\Department;
use App\Entity\Locality;
use App\Entity\Province;
use App\Entity\Street;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class AddressService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProvinceService $provinceService,
        protected DepartmentService $departmentService,
        protected LocalityService $localityService,
        protected StreetService $streetService
    )
    {}

    public function save(AddressTransferDto $data): AddressDto
    {
        $provinceId = $this->provinceService->getByCode($data->getProvinceCode())->getId();
        $departmentId = $this->departmentService->getByCode($data->getDepartmentCode())->getId();
        $localityId = $this->localityService->getByCode($data->getLocalityCode())->getId();
        $streetId = $this->streetService->getByCode($data->getStreetCode())->getId();

        $finger = Uuid::v4()->toBase58();

        $address = new Address();
        $address->setFinger($finger);
        $address->setProvince($this->entityManager->getReference(Province::class, $provinceId));
        $address->setDepartment($this->entityManager->getReference(Department::class, $departmentId));
        $address->setLocality($this->entityManager->getReference(Locality::class, $localityId));
        $address->setStreet($this->entityManager->getReference(Street::class, $streetId));
        $address->setStreetNumber($data->getStreetNumber());
        $address->setPostalCode($data->getPostalCode());
        $address->setReference($data->getReference());
        $address->setCreatedAt(Carbon::now());
        $this->entityManager->persist($address);
        $this->entityManager->flush();
        return new AddressDto($address);
    }
}