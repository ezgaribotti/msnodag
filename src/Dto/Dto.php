<?php

namespace App\Dto;

abstract class Dto
{
    public function __construct(array $data = [])
    {
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
}