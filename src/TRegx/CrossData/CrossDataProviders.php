<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function create(array ...$dataProviders): array
    {
        return DataProviders::crossAll(...$dataProviders);
    }
}
