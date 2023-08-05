<?php
namespace Test\Fixture;

class ThrowIterable implements \IteratorAggregate
{
    public function getIterator()
    {
        throw new \AssertionError("Failed to assert that iterable was not used");
    }
}
