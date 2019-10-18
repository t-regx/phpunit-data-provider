<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function cross(array ...$dataProviders)
    {
        return DataProviders::cross(...$dataProviders);
    }
}
