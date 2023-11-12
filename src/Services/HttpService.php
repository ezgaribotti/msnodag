<?php

namespace App\Services;

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

    public function fetch(string $uri, array $parameters = []): array
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

    public function prepare(string $configPath, array $data): array
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

    public function format(array $data, array $map): array
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

    public function toDto(array $data, string $className): array
    {
        $result = [];
        foreach ($data as $property) $result[] = new $className($property);
        return $result;
    }
}