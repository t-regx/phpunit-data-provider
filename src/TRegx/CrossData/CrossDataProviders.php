<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function cross(array ...$dataProviders): array
    {
        return DataProviders::crossAll(...$dataProviders);
    }
}
