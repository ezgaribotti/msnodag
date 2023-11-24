<?php

namespace App\Rules\Api;

use App\Rules\Rule;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;

class AddressRule extends Rule
{
    public function validateToSave(array $data): void
    {
        $fields = [
            'province_code' => [
                new NotBlank(),
                new Length(2)
            ],
            'department_code' => [
                new NotBlank(),
                new Length(5)
            ],
            'locality_code' => [
                new NotBlank(),
                new Length(11)
            ],
            'street_code' => [
                new NotBlank(),
                new Length(13)
            ],
            'street_number' => [
                new NotBlank(),
                new Type('integer')
            ],
            'postal_code' => [
                new NotBlank()
            ],
            'reference' => new Optional([
                new NotBlank()
            ])
        ];
        $this->inspect($data, $fields);
    }

    public function validateToUpdate(array $data): void
    {
        $fields = [
            'street_number' => [
                new NotNull(),
                new Type('integer')
            ],
            'postal_code' => [
                new NotBlank()
            ],
            'reference' => new Optional([
                new NotBlank()
            ])
        ];

        $this->inspect($data, $fields);
    }
}