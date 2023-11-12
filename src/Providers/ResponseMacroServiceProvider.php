<?php

namespace App\Providers;

use App\Dto\Base\ResponseDto;
use App\Dto\Dto;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseMacroServiceProvider
{
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
            if ($data instanceof Dto) $response->setData($data->toArray());

            if (is_array($data)) {
                $result = [];
                foreach ($data as $key => $value) {
                    if (!$value instanceof Dto) {
                        $message = 'El objeto de transferencia de datos en el listado de respuesta no es válido.';

                        throw new \Exception($message, 500);
                    }
                    $result[] = $value->toArray();
                }
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
        if ($statusCode === 0) $statusCode = 500;
        $response->setStatusCode($statusCode);
        $response->setMessage($message);
        return new JsonResponse($response->toArray(), $statusCode);
    }
}