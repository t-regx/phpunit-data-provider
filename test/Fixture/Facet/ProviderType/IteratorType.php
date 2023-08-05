<?php
namespace Test\Fixture\Facet\ProviderType;

use Test\Fixture\Facet\Iterables;

class IteratorType extends ProviderType
{
    protected function toIterable(array $dataProvider): \Iterator
    {
        return Iterables::iterator($dataProvider);
    }
}
