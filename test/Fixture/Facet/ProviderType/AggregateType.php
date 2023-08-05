<?php
namespace Test\Fixture\Facet\ProviderType;

use Test\Fixture\Facet\Iterables;

class AggregateType extends ProviderType
{
    protected function toIterable(array $dataProvider): \IteratorAggregate
    {
        return Iterables::aggregate($dataProvider);
    }
}
