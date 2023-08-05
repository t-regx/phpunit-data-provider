<?php
namespace Test\Fixture;

use Iterator;

class EntryIterator implements Iterator
{
    /** @var mixed[] */
    private $entries;

    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        [$key, $value] = \current($this->entries);
        return $value;
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        [$key, $value] = \current($this->entries);
        return $key;
    }

    public function next(): void
    {
        \next($this->entries);
    }

    public function valid(): bool
    {
        return \key($this->entries) !== null;
    }

    public function rewind(): void
    {
        \reset($this->entries);
    }
}
