<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class ArrayMatrix
{
    /**
     * @param iterable[] $dataProviders
     */
    public function cross(array $dataProviders): iterable
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

    private function crossTwo(iterable $array1, iterable $array2): \Generator
    {
        $result = [];
        foreach ($array1 as $key1 => $value1) {
            foreach ($array2 as $key2 => $value2) {
                yield $this->keyName($key1, $key2) => array_merge($value1, $value2);
            }
        }
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

    private function quoteKeys(iterable $array): \Generator
    {
        foreach ($array as $key => $value) {
            yield json_encode([$key]) => $value;
        }
    }
}
