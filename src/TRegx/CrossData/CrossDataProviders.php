<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function create($array1, $array2): array
    {
        $result = [];
        foreach ($array1 as $value1) {
            foreach ($array2 as $value2) {
                $result[] = [$value1, $value2];
            }
        }
        return $result;
    }
}
