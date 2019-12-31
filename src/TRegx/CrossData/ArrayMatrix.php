<?php
namespace TRegx\CrossData;

class ArrayMatrix
{
    public function cross(array $dataProviders): array
    {
        if (count($dataProviders) === 1) {
            return $dataProviders[0];
        }
        $first = array_shift($dataProviders);
        $result = $this->quoteKeys($first);
        foreach ($dataProviders as $dataProvider) {
            $result = $this->crossTwo($result, $dataProvider);
        }
        return $result;
    }

    private function crossTwo(array $array1, array $array2): array
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

    private function quoteKeys(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[json_encode([$key])] = $value;
        }
        return $result;
    }
}
