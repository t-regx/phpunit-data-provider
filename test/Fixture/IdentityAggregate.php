<?php
namespace Test\Fixture;

use Traversable;

class IdentityAggregate implements \IteratorAggregate
{
    /** @var Traversable */
    private $traversable;

    public function __construct(Traversable $traversable)
    {
        $this->traversable = $traversable;
    }

    public function getIterator(): Traversable
    {
        return $this->traversable;
    }
}
