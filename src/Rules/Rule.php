<?php

namespace App\Rules;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class Rule
{
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function inspect(array $data, array $fields): void
    {
        $constraints = new Assert\Collection($fields);
        $validator = Validation::createValidator();
        $violations = $validator->validate(
            $this->clean($data), $constraints);
        if (count($violations) !== 0) {
            foreach ($violations as $violation) {

                $domain = 'validators';

                $message = $this->translator->trans(
                    $violation->getMessageTemplate(), $violation->getParameters(), $domain
                );
                throw new \Exception($message);
            }
        }
    }

    public function clean(array $attributes): array
    {
        $result = [];
        foreach ($attributes as $key => $value) {
            if (is_numeric($value)) {
                if (str_contains($value, chr(46))) {
                    $result[$key] = floatval($value);
                } else {
                    $result[$key] = intval($value);
                }
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}