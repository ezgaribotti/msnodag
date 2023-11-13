<?php

namespace App\Services;

use App\Dto\Requests\MakeHttpTransferDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpKernel\KernelInterface;

class HttpService
{
    public function __construct(
        protected KernelInterface $kernel
    )
    {}

    public function make(MakeHttpTransferDto $config): array
    {
        $operation = $config->getOperation();
        $parameters = $this->prepare($operation->getConfigPath(), $config->getData());
        $response = $this->fetch($operation->getUri(), $parameters);
        $response = $response[$operation->getInsideKey()];

        if (!$response) throw new \Exception('No se encontraron datos.', 404);

        $response = $this->format($response, $operation->getResponseMap());
        return $this->toDto($response, $config->getClassName());
    }

    private function fetch(string $uri, array $parameters = []): array
    {
        $client = new Client();
        try {
            $response = $client->get($uri, [
                RequestOptions::QUERY => $parameters
            ]);

        } catch (GuzzleException $exception) {
            throw new \Exception($exception->getMessage());
        }
        return json_decode($response->getBody()->getContents(), true);
    }

    private function prepare(string $configPath, array $data): array
    {
        try {
            $map = json_decode(
                file_get_contents(
                    $this->kernel->getProjectDir(). $configPath), true);
        } catch (\Exception $exception) {

            throw new \Exception('Problemas al establecer el mapa de parámetros.');
        }
        $parameters = $this->format([$data], $map);
        return reset($parameters);
    }

    private function format(array $data, array $map): array
    {
        $result = [];
        foreach ($data as $property) {
            $partial = [];
            foreach ($map as $key => $value) {
                if (is_array($value)) {
                    $reference = $property;
                    foreach ($value as $inside) {
                        $reference = $reference[$inside] ?? null;
                    }
                    if ($reference) $partial[$key] = $reference;
                } else {
                    if (isset($property[$value])) $partial[$key] = $property[$value];
                }
            }
            $result[] = $partial;
        }
        return $result;
    }

    private function toDto(array $data, string $className): array
    {
        $result = [];
        foreach ($data as $property) $result[] = new $className($property);
        return $result;
    }
}