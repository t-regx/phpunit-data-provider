<?php

namespace TRegx\DataProvider;

use function array_diff_assoc;
use function array_intersect;
use function array_unique;

class DataProvidersEach
{
    public static function each(array $values): array
    {
        self::validateDuplicates($values);
        return array_map(static function ($value) {
            return [$value];
        }, $values);
    }

    public static function eachNamed(array $values): array
    {
        self::validateDuplicates($values);
        $result = [];
        foreach ($values as $value) {
            if (is_string($value)) {
                $result[$value] = [$value];
            } else {
                $type = Type::asString($value);
                throw new \InvalidArgumentException("eachNamed() only accepts string, but $type given");
            }
        }
        return $result;
    }

    private static function validateDuplicates(array $values)
    {
        $duplicates = self::getDuplicates($values);
        if (!empty($duplicates)) {
            $value = reset($duplicates);
            throw new DuplicatedValueException($value);
        }
    }

    public static function getDuplicates(array $array)
    {
        return array_values(array_unique(array_intersect($array, array_diff_assoc($array, array_unique($array)))));
    }
}
