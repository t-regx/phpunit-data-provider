<?php
namespace TRegx\CrossData;

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
                    $result[] = [$left, $right];
                }
            }
        }
        return $result;
    }

    private static function validateDuplicates($values)
    {
        $duplicates = self::getDuplicates($values);
        if ($duplicates) {
            $f = reset($duplicates);
            throw new \InvalidArgumentException("Unexpected duplicate '$f' when generating pairs");
        }
    }

    private static function getDuplicates(array $array): array
    {
        return array_unique(array_diff_assoc($array, array_unique($array)));
    }
}
