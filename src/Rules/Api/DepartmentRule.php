<?php

namespace App\Rules\Api;

use App\Rules\Rule;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;

class DepartmentRule extends Rule
{
    public function validate(array $data): void
    {
        $fields = [
            'name' => [
                new NotBlank(),
                new Length(null, 3)
            ],
            'province_code' => new Optional([
                new NotBlank(),
                new Length(2)
            ])
        ];

        $this->inspect($data, $fields);
    }
}