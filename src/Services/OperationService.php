<?php

namespace App\Services;

use App\Dto\Api\OperationDto;
use App\Entity\ServiceOperation;
use Doctrine\ORM\EntityManagerInterface;

class OperationService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}

    public function getByName(string $name): OperationDto
    {
        $operation = $this->entityManager->getRepository(ServiceOperation::class)->findOneBy([
            'name' => $name
        ]);

        if (!$operation) {
            throw new \Exception('No se encontró la operación especificada.');
        }

        $result = new OperationDto();
        $uri = $operation->getService()->getBaseUri() . $operation->getUri();
        $result->setUri($uri);
        $result->setConfigPath($operation->getService()->getConfigPath());
        $result->setInsideKey($operation->getInsideKey());
        $result->setResponseMap($operation->getResponseMap());
        $result->setDefaultData($operation->getDefaultData());
        return $result;
    }
}