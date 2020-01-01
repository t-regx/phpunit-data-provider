<?php
namespace TRegx\DataProvider;

class CrossDataProviders
{
    public static function cross(array ...$dataProviders): array
    {
        return DataProviders::cross(...$dataProviders);
    }
}
