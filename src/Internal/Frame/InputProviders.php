<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\IdempotentIterable;

class InputProviders
{
    /** @var array */
    private $dataProviders;

    public function __construct(array $dataProviders)
    {
        $this->dataProviders = $dataProviders;
    }

    /**
     * @return DataFrame[]
     */
    public function dataFrames(): array
    {
        $result = [];
        foreach ($this->dataProviders as $dataProvider) {
            $result[] = $this->of($this->idempotentIterable($dataProvider));
        }
        return $result;
    }

    public function of(iterable $dataProvider): DataFrame
    {
        if ($dataProvider instanceof DataProvider) {
            return new DataProviderDataFrame($dataProvider);
        }
        return new IterableDataFrame($dataProvider);
    }

    private function idempotentIterable(iterable $dataProvider): iterable
    {
        if ($dataProvider instanceof \Generator) {
            return new IdempotentIterable($dataProvider);
        }
        return $dataProvider;
    }
}
