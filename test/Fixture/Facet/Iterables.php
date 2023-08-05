<?php
namespace Test\Fixture\Facet;

use Test\Fixture\IdentityAggregate;

class Iterables
{
    public static function array(array $elements): array
    {
        return $elements;
    }

    public static function iterator(array $elements): \Iterator
    {
        return new \ArrayIterator($elements);
    }

    public static function traversable(array $elements): \Traversable
    {
        return new \ArrayObject($elements);
    }

    public static function aggregate(array $elements): \IteratorAggregate
    {
        return new \ArrayObject($elements);
    }

    public static function generator(array $elements): \Generator
    {
        yield from $elements;
    }

    public static function nestedAggregate(array $elements): \IteratorAggregate
    {
        return new IdentityAggregate(new IdentityAggregate(new \ArrayObject($elements)));
    }
}
