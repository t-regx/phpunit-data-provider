<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Provider\DictionaryProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\JoinProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ListProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\TuplesProvider;
use TRegx\PhpUnit\DataProviders\Internal\Provider\ZipProvider;
use TRegx\PhpUnit\DataProviders\Internal\View\PhpUnitDataset;

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

    public static function tuples(array $set, array ...$sets): DataProvider
    {
        return new TuplesProvider(\array_merge([$set], $sets));
    }

    public static function dictionary(array $dictionary): DataProvider
    {
        return new DictionaryProvider($dictionary);
    }

    public static function join(array $dataProvider, array ...$dataProviders): DataProvider
    {
        return new JoinProvider(\array_merge([$dataProvider], $dataProviders));
    }

    public static function zip(array $dataProvider, array ...$dataProviders): DataProvider
    {
        return new ZipProvider(\array_merge([$dataProvider], $dataProviders));
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
