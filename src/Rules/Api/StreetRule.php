<?php

namespace App\Rules\Api;

use App\Rules\Rule;

class StreetRule extends Rule
{
    public function validateToSearch(array $data): void
    {
        $fields = [
            'name' => 'required|min:3',
            'department_code' => 'size:5'
        ];

        $this->inspect($data, $fields);
    }
}