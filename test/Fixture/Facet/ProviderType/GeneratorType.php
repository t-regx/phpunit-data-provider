<?php
namespace Test\Fixture\Facet\ProviderType;

use Test\Fixture\Facet\Iterables;

class GeneratorType extends ProviderType
{
    protected function toIterable(array $dataProvider): iterable
    {
        return Iterables::generator($dataProvider);
    }
}
