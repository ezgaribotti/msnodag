<?php

namespace App\Services;

use App\Dto\Api\DepartmentDto;
use App\Dto\Requests\DepartmentTransferDto;
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
        $departments = $this->httpService->fetch($operation->getUri());
        $departments = $departments[$operation->getInsideKey()];

        if (!$departments) throw new \Exception('No se encontraron departamentos.', 404);

        $departments = $this->httpService->format($departments, $operation->getResponseMap());
        $departments = $this->httpService->toDto($departments, DepartmentDto::class);
        $result = [];
        foreach ($departments as $department) {
            if ($department instanceof DepartmentDto) $result[] = $department->toArray();
        }
        return $result;
    }
}