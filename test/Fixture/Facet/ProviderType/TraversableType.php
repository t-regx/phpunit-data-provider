<?php
namespace Test\Fixture\Facet\ProviderType;

use Test\Fixture\Facet\Iterables;

class TraversableType extends ProviderType
{
    protected function toIterable(array $dataProvider): \Traversable
    {
        return Iterables::traversable($dataProvider);
    }
}
