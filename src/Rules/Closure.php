<?php

namespace App\Rules;

use Symfony\Component\Validator\Constraints as Assert;

abstract class Closure
{
    const REQUIRED = 'required';
    const NULLABLE = 'nullable';
    const INTEGER = 'integer';
    const BOOLEAN = 'boolean';
    const FLOAT = 'float';
    const SIZE = 'size';
    const MINIMUM = 'min';
    const MAXIMUM = 'max';
    const POSITIVE = 'positive';
    const NEGATIVE = 'negative';

    public function assign(array $fields): array
    {
        $result = [];
        foreach ($fields as $key => $value) {
            $rules = explode(chr(124), $value);
            $root = reset($rules);
            if ($root === self::REQUIRED) {
                unset($rules[0]);
                $rules = array_values($rules);
            }

            $assert = [new Assert\NotNull(), new Assert\NotBlank()];

            foreach ($rules as $rule) {
                $specificValue = null;
                $specifications = explode(chr(58), $rule);
                $rule = reset($specifications);
                if (count($specifications) > 1) $specificValue = end($specifications);
                if ($specificValue && is_numeric($specificValue))
                    $specificValue = intval($specificValue);

                if ($rule === self::NULLABLE) unset($assert[0]);
                elseif ($rule === self::INTEGER) $assert[] = new Assert\Type(self::INTEGER);
                elseif ($rule === self::BOOLEAN) $assert[] = new Assert\Type(self::BOOLEAN);
                elseif ($rule === self::FLOAT) $assert[] = new Assert\Type(self::FLOAT);
                elseif ($rule === self::SIZE) $assert[] = new Assert\Length($specificValue);
                elseif ($rule === self::MINIMUM) $assert[] = new Assert\Length(null, $specificValue);
                elseif ($rule === self::MAXIMUM) $assert[] = new Assert\Length(null, null, $specificValue);
                elseif ($rule === self::POSITIVE) $assert[] = new Assert\Positive();
                elseif ($rule === self::NEGATIVE) $assert[] = new Assert\Negative();
                else
                    throw new \Exception('Una o más reglas de validación no son válidas.');
            }

            $assert = array_values($assert);
            if ($root === self::REQUIRED) $result[$key] = $assert;
            else $result[$key] = new Assert\Optional($assert);
        }
        return $result;
    }
}