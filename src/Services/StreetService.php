<?php

namespace App\Services;

use App\Dto\Api\StreetDto;
use App\Dto\Requests\MakeHttpTransferDto;
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

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setClassName(StreetDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }
}