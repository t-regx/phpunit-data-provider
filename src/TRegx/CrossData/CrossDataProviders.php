<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function builder(): CrossDataProviders
    {
        return new CrossDataProviders();
    }

    public function create(array $array1, array $array2): array
    {
        $result = [];
        foreach ($array1 as $key1 => $value1) {
            foreach ($array2 as $key2 => $value2) {
                if (is_int($key1) && is_int($key2)) {
                    $result[] = [$value1, $value2];
                } else {
                    $result[self::keyName($key1, $key2)] = [$value1, $value2];
                }
            }
        }
        return $result;
    }

    private function keyName($key1, $key2): string
    {
        return self::formatKey($key1) . ' / ' . self::formatKey($key2);
    }

    private function formatKey($key)
    {
        return is_int($key) ? "#$key" : $key;
    }
}