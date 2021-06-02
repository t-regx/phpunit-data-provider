<?php

namespace TRegx\DataProvider;

class CrossDataProviders
{
    /**
     * @param array<string|int, array<int, mixed>> ...$dataProviders
     *
     * @return array<string, array<int, mixed>>
     */
    public static function cross(array ...$dataProviders): array
    {
        return DataProviders::cross(...$dataProviders);
    }
}
