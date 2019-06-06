<?php
namespace TRegx\CrossData;

class DataProviders
{
    public static function cross(array ...$dataProviders): array
    {
        return (new ArrayMatrix())->cross($dataProviders);
    }
}
