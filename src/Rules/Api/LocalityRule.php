<?php

namespace App\Rules\Api;

use App\Rules\Rule;
use Symfony\Component\Validator\Constraints as Assert;

class LocalityRule extends Rule
{
    public function validate(array $data): void
    {
        $fields = [
            'name' => [
                new Assert\NotBlank(),
                new Assert\Length(null, 3)
            ],
            'department_code' => [
                new Assert\NotBlank()
            ]
        ];

        $this->inspect($data, $fields);
    }
}