<?php
namespace Test\Fixture\Facet\ProviderType;

trait ProviderTypes
{
    /**
     * @return ProviderType[]
     */
    public function providerTypes(): array
    {
        return [
            'array'                         => [new ArrayType()],
            \IteratorAggregate::class       => [new AggregateType()],
            \IteratorAggregate::class . '+' => [new NestedAggregateType()],
            \Iterator::class                => [new IteratorType()],
            \Traversable::class             => [new TraversableType()],
            \Generator::class               => [new GeneratorType()],
        ];
    }
}
