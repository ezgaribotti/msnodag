<?php

namespace App\Services;

use App\Dto\Api\DepartmentDto;
use App\Dto\Requests\DepartmentTransferDto;
use App\Dto\Requests\MakeHttpTransferDto;
use App\Entity\Department;
use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;

class DepartmentService
{
    const OPERATION_NAME = 'departments';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService,
        protected RecoveryService $recoveryService,
        protected ProvinceService $provinceService
    )
    {}

    public function search(DepartmentTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setDto(DepartmentDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }

    public function getByCode(string $code): DepartmentDto
    {
        $data = $this->recoveryService->recoverByCode(
            $code, self::OPERATION_NAME, Department::class, DepartmentDto::class);

        if (!$data->getId()) $this->save($data);
        return $data;
    }

    public function save(DepartmentDto $data): void
    {
        $provinceId = $this->provinceService->getByCode($data->getProvinceCode())->getId();

        $department = new Department();
        $department->setName($data->getName());
        $department->setExternalCode($data->getExternalCode());
        $department->setProvince(
            $this->entityManager->getReference(Province::class, $provinceId));
        $department->setLatitude($data->getLatitude());
        $department->setLongitude($data->getLongitude());
        $this->entityManager->persist($department);
        $this->entityManager->flush();
        $data->setId($department->getId());
    }
}