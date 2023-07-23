<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\PhpUnitDataset;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DictionaryProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\IdentityProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ListProvider;

abstract class DataProvider implements \IteratorAggregate
{
    public static function of(array $dataProvider): DataProvider
    {
        return new IdentityProvider($dataProvider);
    }

    public static function list(...$values): DataProvider
    {
        return new ListProvider($values);
    }

    public static function dictionary(array $dictionary): DataProvider
    {
        return new DictionaryProvider($dictionary);
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
