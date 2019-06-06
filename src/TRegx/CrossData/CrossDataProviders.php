<?php
namespace TRegx\CrossData;

class CrossDataProviders
{
    public static function builder(): CrossDataProviders
    {
        return new CrossDataProviders();
    }

    public function create(array ...$dataProviders): array
    {
        return (new ArrayMatrix())->cross($dataProviders);
    }
}
