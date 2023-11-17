<?php

namespace App\Services;

use App\Dto\Api\LocalityDto;
use App\Dto\Requests\LocalityTransferDto;
use App\Dto\Requests\MakeHttpTransferDto;
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

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setDto(LocalityDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }
}