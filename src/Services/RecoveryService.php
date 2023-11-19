<?php

namespace App\Services;

use App\Dto\Requests\MakeHttpTransferDto;
use Doctrine\ORM\EntityManagerInterface;

class RecoveryService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OperationService $operationService,
        protected HttpService $httpService
    )
    {}

    public function recoverAll(string $entity, string $dto): array
    {
        $data = $this->entityManager->getRepository($entity)->findAll();
        if (!$data)
            throw new \Exception('No se encontraron registros.', 404);

        $result = [];
        foreach ($data as $attributes) $result[] = new $dto($attributes);
        return $result;
    }

    public function recoverById(int $id, string $entity, string $dto): mixed
    {
        $data = $this->entityManager->getRepository($entity)->find($id);
        if (!$data)
            throw new \Exception('No se encontró el registro con id '. $id .'.', 404);
        return new $dto($data);
    }

    public function recoverByCode(string $code, string $operationName, string $entity, string $dto): mixed
    {
        $data = $this->entityManager->getRepository($entity)->findOneBy([
            'external_code' => $code
        ]);
        if (!$data) {
            $operation = $this->operationService->getByName($operationName);
            $config = new MakeHttpTransferDto();

            $config->setData([
                'external_code' => $code
            ]);
            $config->setDto($dto);
            $config->setOperation($operation);
            $response = $this->httpService->make($config, true);
            if (!$response)
                throw new \Exception('No se encontró el registro con código '. $code .'.', 404);

            $data = reset($response);
            $data->setId(null);
            return $data;
        }
        return new $dto($data);
    }

    public function validateCodeLength(string $code, int $length): void
    {
        if (strlen($code) !== $length)
            throw new \Exception('El código debe tener una longitud de '. $length .' caracteres.');
    }
}