<?php

namespace App\Services;

use App\Dto\Api\DepartmentDto;
use App\Dto\Requests\DepartmentTransferDto;
use App\Dto\Requests\MakeHttpTransferDto;
use Doctrine\ORM\EntityManagerInterface;

class DepartmentService
{
    const OPERATION_NAME = 'departments';

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService
    )
    {}

    public function search(DepartmentTransferDto $data): array
    {
        $operation = $this->operationService->getByName(self::OPERATION_NAME);

        $config = new MakeHttpTransferDto();
        $config->setData($data->toArray());
        $config->setClassName(DepartmentDto::class);
        $config->setOperation($operation);

        return $this->httpService->make($config);
    }
}