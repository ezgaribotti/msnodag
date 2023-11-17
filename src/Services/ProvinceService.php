<?php

namespace App\Services;

use App\Dto\Api\ProvinceDto;
use App\Dto\Requests\MakeHttpTransferDto;
use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;

class ProvinceService
{
    const OPERATION_NAME = 'provinces';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService,
        protected RecoveryService $recoveryService
    )
    {}

    public function getAll(): array
    {
        return $this->recoveryService->recoverAll(Province::class, ProvinceDto::class);
    }

    public function getByCode(string $code): ProvinceDto
    {
        return $this->recoveryService->recoverByCode(
            $code, self::OPERATION_NAME, Province::class, ProvinceDto::class);
    }

    public function load(): void
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);
        $counted = $this->entityManager->getRepository(Province::class)->count([]);

        if ($counted > 0) throw new \Exception('Las provincias ya se guardaron previamente.');

        $config = new MakeHttpTransferDto();
        $config->setData([]);
        $config->setDto(ProvinceDto::class);
        $config->setOperation($operation);

        $response = $this->httpService->make($config);
        foreach ($response as $data) {
            $province = new Province();
            $province->setName($data->getName());
            $province->setExternalCode($data->getExternalCode());
            $province->setLatitude($data->getLatitude());
            $province->setLongitude($data->getLongitude());
            $this->entityManager->persist($province);
        }
        $this->entityManager->flush();
    }
}