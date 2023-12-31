<?php

namespace App\Services;

use App\Dto\Api\AddressDto;
use App\Dto\Api\SavedAddressDto;
use App\Dto\Requests\AddressTransferDto;
use App\Dto\Requests\UpdateAddressTransferDto;
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
        protected RecoveryService $recoveryService,
        protected ProvinceService $provinceService,
        protected DepartmentService $departmentService,
        protected LocalityService $localityService,
        protected StreetService $streetService
    )
    {}

    public function getByFinger(string $finger): AddressDto
    {
        $this->validateFinger($finger);

        $criteria = ['finger' => $finger];

        $this->recoveryService->validateExists(Address::class, $criteria);
        $address = $this->entityManager->getRepository(Address::class)->findOneBy($criteria);
        $result = new AddressDto($address);
        $result->setId($finger);
        $result->setProvinceName($address->getProvince()->getName());
        $result->setDepartmentName($address->getDepartment()->getName());
        $result->setLocalityName($address->getLocality()->getName());
        $result->setStreetName($address->getStreet()->getName());
        $result->setNomenclature($address->getStreet()->getNomenclature());
        $result->setCreatedAt($address->getCreatedAt());
        $result->setUpdatedAt($address->getUpdatedAt());
        return $result;
    }

    public function save(AddressTransferDto $data): SavedAddressDto
    {
        $provinceId = $this->provinceService->getByCode($data->getProvinceCode())->getId();
        $departmentId = $this->departmentService->getByCode($data->getDepartmentCode())->getId();
        $localityId = $this->localityService->getByCode($data->getLocalityCode())->getId();
        $streetId = $this->streetService->getByCode($data->getStreetCode())->getId();

        $finger = Uuid::v4()->toBase58();
        $now = Carbon::now();
        $address = new Address();
        $address->setFinger($finger);
        $address->setProvince($this->entityManager->getReference(Province::class, $provinceId));
        $address->setDepartment($this->entityManager->getReference(Department::class, $departmentId));
        $address->setLocality($this->entityManager->getReference(Locality::class, $localityId));
        $address->setStreet($this->entityManager->getReference(Street::class, $streetId));
        $address->setStreetNumber($data->getStreetNumber());
        $address->setPostalCode($data->getPostalCode());
        $address->setReference($data->getReference());
        $address->setCreatedAt($now);
        $this->entityManager->persist($address);
        $this->entityManager->flush();

        $result = new SavedAddressDto();
        $result->setId($finger);
        $result->setCreatedAt($now);
        return $result;
    }

    public function updateByFinger(string $finger, UpdateAddressTransferDto $data): void
    {
        $this->validateFinger($finger);

        $criteria = ['finger' => $finger];

        $this->recoveryService->validateExists(Address::class, $criteria);
        $address = $this->entityManager->getRepository(Address::class)->findOneBy($criteria);
        $now = Carbon::now();
        $address->setStreetNumber($data->getStreetNumber());
        $address->setPostalCode($data->getPostalCode());
        $address->setReference($data->getReference());
        $address->setUpdatedAt($now);
        $this->entityManager->flush();
    }

    public function deleteByFinger(string $finger): void
    {
        $this->validateFinger($finger);

        $criteria = ['finger' => $finger];

        $this->recoveryService->validateExists(Address::class, $criteria);
        $address = $this->entityManager->getRepository(Address::class)->findOneBy($criteria);
        $this->entityManager->remove($address);
        $this->entityManager->flush();
    }

    private function validateFinger(string $finger): void
    {
        try {
            $finger = Uuid::fromBase58($finger);
        } catch (\Exception $exception) {

            throw new \Exception('No se reconoce el formato del id.');
        }

        if (!Uuid::isValid($finger))

            throw new \Exception('El id de la dirección no es válido.');
    }
}