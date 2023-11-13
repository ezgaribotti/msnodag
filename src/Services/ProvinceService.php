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
        protected HttpService $httpService
    )
    {}

    public function getAll(): array
    {
        $provinces = $this->entityManager->getRepository(Province::class)->findAll();
        if (!$provinces) throw new \Exception('No se encontraron provincias.', 404);

        $result = [];
        foreach ($provinces as $province) {
            $transport = new ProvinceDto();
            $transport->setName($province->getName());
            $transport->setExternalCode($province->getExternalCode());
            $transport->setLatitude($province->getLatitude());
            $transport->setLongitude($province->getLongitude());
            $result[] = $transport->toArray();
        }
        return $result;
    }

    public function load(): void
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);
        $counted = $this->entityManager->getRepository(Province::class)->count([]);

        if ($counted > 0) throw new \Exception('Las provincias ya se guardaron previamente.');

        $config = new MakeHttpTransferDto();
        $config->setData([]);
        $config->setClassName(ProvinceDto::class);
        $config->setOperation($operation);

        $provinces = $this->httpService->make($config);
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