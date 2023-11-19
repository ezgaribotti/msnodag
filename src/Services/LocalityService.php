<?php

namespace App\Services;

use App\Dto\Api\LocalityDto;
use App\Dto\Requests\LocalityTransferDto;
use App\Dto\Requests\MakeHttpTransferDto;
use App\Entity\Department;
use App\Entity\Locality;
use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;

class LocalityService
{
    const OPERATION_NAME = 'localities';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService,
        protected RecoveryService $recoveryService,
        protected ProvinceService $provinceService,
        protected DepartmentService $departmentService
    )
    {}

    public function search(LocalityTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setDto(LocalityDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }

    public function getByCode(string $code): LocalityDto
    {
        $this->recoveryService->validateCodeLength($code, 11);

        $data = $this->recoveryService->recoverByCode(
            $code, self::OPERATION_NAME, Locality::class, LocalityDto::class);

        if (!$data->getId()) $this->save($data);
        return $data;
    }

    public function save(LocalityDto $data): void
    {
        $provinceId = $this->provinceService->getByCode($data->getProvinceCode())->getId();

        $locality = new Locality();
        $locality->setName($data->getName());
        $locality->setExternalCode($data->getExternalCode());
        $locality->setCategory($data->getCategory());
        $locality->setProvince(
            $this->entityManager->getReference(Province::class, $provinceId));
        if ($data->getDepartmentCode()) {
            $departmentId = $this->departmentService->getByCode($data->getDepartmentCode())->getId();
            $locality->setDepartment(
                $this->entityManager->getReference(Department::class, $departmentId));
        }
        $locality->setLatitude($data->getLatitude());
        $locality->setLongitude($data->getLongitude());
        $this->entityManager->persist($locality);
        $this->entityManager->flush();
        $data->setId($locality->getId());
    }
}