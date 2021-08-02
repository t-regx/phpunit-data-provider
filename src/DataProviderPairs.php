<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class DataProviderPairs
{
    public static function getMixedPairs(array $values): array
    {
        return self::getPairs($values, true);
    }

    public static function getDistinctPairs(array $values): array
    {
        return self::getPairs($values, false);
    }

    private static function getPairs(array $values, bool $allowDuplicates): array
    {
        self::validateDuplicates($values);

        $result = [];
        foreach ($values as $left) {
            foreach ($values as $right) {
                if ($left !== $right || $allowDuplicates) {
                    $result[self::formatPairKey($left, $right)] = [$left, $right];
                }
            }
        }
        return $result;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private static function validateDuplicates($values): void
    {
        $duplicates = self::getDuplicates($values);
        if ($duplicates) {
            $f = reset($duplicates);
            throw new \InvalidArgumentException("Unexpected duplicate '$f' when generating pairs");
        }
    }

    private static function getDuplicates(array $array): array
    {
        return self::arrayScalarUnique(array_diff_assoc($array, self::arrayScalarUnique($array)));
    }

    private static function arrayScalarUnique(array $array): array
    {
        return array_unique(array_filter($array, [self::class, 'isComparable']));
    }

    private static function isComparable($input): bool
    {
        return !is_object($input) && !is_array($input);
    }

    private static function formatPairKey($left, $right): string
    {
        return Type::asPrettyString($left) . ',' . Type::asPrettyString($right);
    }
}
