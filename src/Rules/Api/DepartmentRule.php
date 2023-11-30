<?php

namespace App\Rules\Api;

use App\Rules\Rule;

class DepartmentRule extends Rule
{
    public function validateToSearch(array $data): void
    {
        $fields = [
            'name' => 'required|min:3',
            'province_code' => 'size:2'
        ];

        $this->inspect($data, $fields);
    }
}