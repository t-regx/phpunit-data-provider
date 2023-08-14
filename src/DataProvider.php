<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Provider\CrossProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DictionaryProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DistinctPairsProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DropProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\JoinProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ListProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\MapProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\PairsProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\SliceProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\TuplesProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ZipProvider;
use TRegx\PhpUnit\DataProviders\Internal\View\PhpUnitDataset;

abstract class DataProvider implements \IteratorAggregate
{
    public static function of(iterable $dataProvider): DataProvider
    {
        return new JoinProvider([$dataProvider]);
    }

    public static function list(...$values): DataProvider
    {
        return new ListProvider($values);
    }

    public static function tuples(array $set, array ...$sets): DataProvider
    {
        return new TuplesProvider(\array_merge([$set], $sets));
    }

    public static function dictionary(array $dictionary): DataProvider
    {
        return new DictionaryProvider($dictionary);
    }

    public static function join(iterable $dataProvider, iterable ...$dataProviders): DataProvider
    {
        return new JoinProvider(\array_merge([$dataProvider], $dataProviders));
    }

    public static function zip(iterable $dataProvider, iterable ...$dataProviders): DataProvider
    {
        return new ZipProvider(\array_merge([$dataProvider], $dataProviders));
    }

    public static function cross(iterable $dataProvider, iterable ...$dataProviders): DataProvider
    {
        return new CrossProvider(\array_merge([$dataProvider], $dataProviders));
    }

    public static function pairs($value1, $value2, ...$values): DataProvider
    {
        return new PairsProvider(\array_merge([$value1, $value2], $values));
    }

    public static function distinctPairs($value1, $value2, ...$values): DataProvider
    {
        return new DistinctPairsProvider(\array_merge([$value1, $value2], $values));
    }

    public function map(callable $mapper): DataProvider
    {
        return new MapProvider($this, $mapper);
    }

    public function slice(int $start, int $count = null): DataProvider
    {
        return new SliceProvider($this, $start, $count);
    }

    public function drop(int $columnIndex, int...$columnIndices): DataProvider
    {
        return new DropProvider($this, \array_merge([$columnIndex], $columnIndices));
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
