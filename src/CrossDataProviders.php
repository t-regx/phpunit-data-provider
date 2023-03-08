<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class CrossDataProviders
{
    /**
     * @param array<string|int, array<int, mixed>>|\Iterator<string|int, \Iterator<int, mixed>> ...$dataProviders
     *
     * @return array<string|int, array<int, mixed>>|\Iterator<string|int, \Iterator<int, mixed>>
     */
    public static function cross(iterable ...$dataProviders): iterable
    {
        return DataProviders::cross(...$dataProviders);
    }
}
