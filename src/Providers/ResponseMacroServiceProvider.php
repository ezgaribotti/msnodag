<?php

namespace App\Providers;

use App\Dto\Base\ResponseDto;
use App\Dto\Dto;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseMacroServiceProvider
{
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public function success(Dto|array $data = null, string $message = null): JsonResponse
    {
        if (!$message) {
            $message = 'Solicitud completada con éxito.';
        }
        $response = new ResponseDto();
        $response->setSuccess(true);
        $response->setStatusCode(200);
        $response->setMessage($message);
        if ($data) {
            if ($data instanceof Dto)
                $response->setData($this->verifyDto($data));

            if (is_array($data)) {
                $result = [];
                foreach ($data as $property) $result[] = $this->verifyDto($property);
                $response->setData($result);
            }
        }
        return new JsonResponse($response->toArray());
    }

    public function error(string $message = null, int $statusCode = 500): JsonResponse
    {
        if (!$message) {
            $message = 'Ocurrió un problema al procesar la solicitud.';
        }
        $response = new ResponseDto();
        $response->setSuccess(false);
        if (!is_numeric($statusCode)) $statusCode = 500;
        if ($statusCode <= 100 || $statusCode > 600) $statusCode = 500;
        $response->setStatusCode($statusCode);
        $response->setMessage($message);
        return new JsonResponse($response->toArray(), $statusCode);
    }

    private function verifyDto(mixed $dto): array
    {
        if (!$dto instanceof Dto) {
            $message = 'El objeto de transferencia de datos en el listado de respuesta no es válido.';

            throw new \Exception($message, 500);
        }
        $result = [];
        foreach ($dto->toArray() as $key => $value) {
            if ($value instanceof \DateTimeInterface)
                $value = $value->format(self::DEFAULT_FORMAT);
            $result[$key] = $value;
        }
        return $result;
    }
}