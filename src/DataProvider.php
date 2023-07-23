<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\PhpUnitDataset;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DictionaryProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\JoinProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ListProvider;

abstract class DataProvider implements \IteratorAggregate
{
    public static function of(array $dataProvider): DataProvider
    {
        return new JoinProvider([$dataProvider]);
    }

    public static function list(...$values): DataProvider
    {
        return new ListProvider($values);
    }

    public static function dictionary(array $dictionary): DataProvider
    {
        return new DictionaryProvider($dictionary);
    }

    public static function join(array $dataProvider, array ...$dataProviders): DataProvider
    {
        return new JoinProvider(\array_merge([$dataProvider], $dataProviders));
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
