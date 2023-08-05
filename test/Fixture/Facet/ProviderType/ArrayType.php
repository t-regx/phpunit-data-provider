<?php
namespace Test\Fixture\Facet\ProviderType;

class ArrayType extends ProviderType
{
    protected function toIterable(array $dataProvider): array
    {
        return $dataProvider;
    }
}
