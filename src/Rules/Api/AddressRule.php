<?php

namespace App\Rules\Api;

use App\Rules\Rule;

class AddressRule extends Rule
{
    public function validateToSave(array $data): void
    {
        $fields = [
            'province_code' => 'required|size:2',
            'department_code' => 'required|size:5',
            'locality_code' => 'required|size:11',
            'street_code' => 'required|size:13',
            'street_number' => 'required|integer|positive',
            'postal_code' => 'required',
            'reference' => 'nullable'
        ];
        $this->inspect($data, $fields);
    }

    public function validateToUpdate(array $data): void
    {
        $fields = [
            'street_number' => 'required|integer|positive',
            'postal_code' => 'required',
            'reference' => 'nullable'
        ];

        $this->inspect($data, $fields);
    }
}