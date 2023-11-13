<?php

namespace App\Dto;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class Dto
{
    public function __construct(array|object $data = [])
    {
        if (is_object($data)) $data = $this->serialize($data);
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            if ($value instanceof Dto) {
                $result[$key] = get_object_vars($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    private function serialize(object $data): array
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        try {
            $result = $serializer->normalize($data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        if (!is_array($result)) throw new \Exception('El objeto no es válido para serializar.');
        return $result;
    }
}