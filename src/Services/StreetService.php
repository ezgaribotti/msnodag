<?php

namespace App\Services;

use App\Dto\Api\StreetDto;
use App\Dto\Requests\StreetTransferDto;
use Doctrine\ORM\EntityManagerInterface;

class StreetService
{
    const OPERATION_NAME = 'streets';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService
    )
    {}

    public function search(StreetTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);
        $parameters = $this->httpService->prepare($operation->getConfigPath(), $data->toArray());
        $streets = $this->httpService->fetch($operation->getUri(), $parameters);
        $streets = $streets[$operation->getInsideKey()];

        if (!$streets) throw new \Exception('No se encontraron calles.', 404);

        $streets = $this->httpService->format($streets, $operation->getResponseMap());
        $streets = $this->httpService->toDto($streets, StreetDto::class);
        $result = [];
        foreach ($streets as $street) {
            if ($street instanceof StreetDto) $result[] = $street->toArray();
        }
        return $result;
    }
}