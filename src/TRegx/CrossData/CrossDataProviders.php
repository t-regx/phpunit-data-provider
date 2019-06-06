<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function builder(): CrossDataProviders
    {
        return new CrossDataProviders();
    }

    public function cross(array ...$dataProviders): array
    {
        $result = array_shift($dataProviders);
        foreach ($dataProviders as $dataProvider) {
            $result = $this->crossTwo($result, $dataProvider);
        }
        return $result;
    }

    public function crossTwo(array $array1, array $array2): array
    {
        $result = [];
        foreach ($array1 as $key1 => $value1) {
            foreach ($array2 as $key2 => $value2) {
                $result[self::keyName($key1, $key2)] = array_merge($value1, $value2);
            }
        }
        return $result;
    }

    private function keyName($previous, $new): string
    {
        $keys = json_decode($previous);
        if (!is_array($keys)) {
            $keys = [$previous];
        }
        $keys[] = $new;
        return json_encode($keys);
    }
}
