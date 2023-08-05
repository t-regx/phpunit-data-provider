<?php
namespace Test\Fixture\Facet\ProviderType;

use Test\Fixture\Facet\Iterables;

class NestedAggregateType extends ProviderType
{
    protected function toIterable(array $dataProvider): \IteratorAggregate
    {
        return Iterables::nestedAggregate($dataProvider);
    }
}
