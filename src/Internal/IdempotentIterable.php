<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

class IdempotentIterable implements \IteratorAggregate
{
    /** @var \Traversable */
    private $traversable;
    /** @var array|null */
    private $cached = null;

    public function __construct(\Traversable $traversable)
    {
        $this->traversable = $traversable;
    }

    public function getIterator(): \Iterator
    {
        if ($this->cached === null) {
            $this->cached = \iterator_to_array($this->traversable);
        }
        return new \ArrayIterator($this->cached);
    }
}
