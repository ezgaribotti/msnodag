<?php

namespace App\Services;

use App\Dto\Api\StreetDto;
use App\Dto\Requests\MakeHttpTransferDto;
use App\Dto\Requests\StreetTransferDto;
use App\Entity\Department;
use App\Entity\Province;
use App\Entity\Street;
use Doctrine\ORM\EntityManagerInterface;

class StreetService
{
    const OPERATION_NAME = 'streets';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService,
        protected RecoveryService $recoveryService,
        protected ProvinceService $provinceService,
        protected DepartmentService $departmentService
    )
    {}

    public function search(StreetTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setDto(StreetDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }

    public function getByCode(string $code): StreetDto
    {
        $this->recoveryService->validateCodeLength($code, 13);

        $data = $this->recoveryService->recoverByCode(
            $code, self::OPERATION_NAME, Street::class, StreetDto::class);

        if (!$data->getId()) $this->save($data);
        return $data;
    }

    public function save(StreetDto $data): void
    {
        $provinceId = $this->provinceService->getByCode($data->getProvinceCode())->getId();

        $street = new Street();
        $street->setName($data->getName());
        $street->setExternalCode($data->getExternalCode());
        $street->setCategory($data->getCategory());
        $street->setProvince(
            $this->entityManager->getReference(Province::class, $provinceId));
        if ($data->getDepartmentCode()) {
            $departmentId = $this->departmentService->getByCode($data->getDepartmentCode())->getId();
            $street->setDepartment(
                $this->entityManager->getReference(Department::class, $departmentId));
        }
        $street->setNomenclature($data->getNomenclature());
        $this->entityManager->persist($street);
        $this->entityManager->flush();
        $data->setId($street->getId());
    }
}