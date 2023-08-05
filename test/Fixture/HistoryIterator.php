<?php
namespace Test\Fixture;

class HistoryIterator extends \IteratorIterator
{
    /** @var string[] */
    public $history = [];

    public function __construct(array $values)
    {
        parent::__construct(new \ArrayIterator($values));
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        $this->history[] = __FUNCTION__;
        return parent::current();
    }

    public function next(): void
    {
        $this->history[] = __FUNCTION__;
        parent::next();
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        $this->history[] = __FUNCTION__;
        return parent::key();
    }

    public function valid(): bool
    {
        $this->history[] = __FUNCTION__;
        return parent::valid();
    }

    public function rewind(): void
    {
        $this->history[] = __FUNCTION__;
        parent::rewind();
    }
}
