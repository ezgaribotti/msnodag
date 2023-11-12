<?php

namespace App\Services;

use App\Dto\Api\LocalityDto;
use App\Dto\Requests\LocalityTransferDto;
use Doctrine\ORM\EntityManagerInterface;

class LocalityService
{
    const OPERATION_NAME = 'localities';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService
    )
    {}

    public function search(LocalityTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);
        $parameters = $this->httpService->prepare($operation->getConfigPath(), $data->toArray());
        $localities = $this->httpService->fetch($operation->getUri(), $parameters);
        $localities = $localities[$operation->getInsideKey()];

        if (!$localities) throw new \Exception('No se encontraron localidades.', 404);

        $localities = $this->httpService->format($localities, $operation->getResponseMap());
        $localities = $this->httpService->toDto($localities, LocalityDto::class);
        $result = [];
        foreach ($localities as $locality) {
            if ($locality instanceof LocalityDto) $result[] = $locality->toArray();
        }
        return $result;
    }
}