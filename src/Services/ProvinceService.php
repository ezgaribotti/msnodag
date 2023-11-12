<?php

namespace App\Services;

use App\Dto\Api\ProvinceDto;
use App\Entity\Province;
use Doctrine\ORM\EntityManagerInterface;

class ProvinceService
{
    const OPERATION_NAME = 'provinces';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService
    )
    {}

    public function load(): void
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);
        $counted = $this->entityManager->getRepository(Province::class)->count([]);

        if ($counted > 0) throw new \Exception('Las provincias ya se guardaron previamente.');

        $provinces = $this->httpService->fetch($operation->getUri());
        $provinces = $provinces[$operation->getInsideKey()];
        $provinces = $this->httpService->format($provinces, $operation->getResponseMap());
        $provinces = $this->httpService->toDto($provinces, ProvinceDto::class);
        foreach ($provinces as $data) {
            if ($data instanceof ProvinceDto) {
                $province = new Province();
                $province->setName($data->getName());
                $province->setExternalCode($data->getExternalCode());
                $province->setLatitude($data->getLatitude());
                $province->setLongitude($data->getLongitude());
                $this->entityManager->persist($province);
            }
        }
        $this->entityManager->flush();
    }
}