<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\PhpUnitDataset;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ListProvider;

abstract class DataProvider implements \IteratorAggregate
{
    public static function list(...$values): DataProvider
    {
        return new ListProvider($values);
    }

    public function getIterator(): \Iterator
    {
        yield from new PhpUnitDataset($this);
    }

    /**
     * @return DataRow[]
     */
    abstract protected function dataset(): array;
}
