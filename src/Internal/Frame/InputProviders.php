<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\IdempotentIterable;

class InputProviders
{
    /** @var DataFrame[] */
    private $frames = [];

    public function __construct(array $dataProviders)
    {
        foreach ($dataProviders as $dataProvider) {
            $this->frames[] = $this->dataFrame($dataProvider);
        }
    }

    private function dataFrame(iterable $dataProvider): DataFrame
    {
        if ($dataProvider instanceof DataProvider) {
            return new DataProviderDataFrame($dataProvider);
        }
        return new IterableDataFrame($this->idempotentIterable($dataProvider));
    }

    private function idempotentIterable(iterable $dataProvider): iterable
    {
        if (\is_array($dataProvider)) {
            return $dataProvider;
        }
        return new IdempotentIterable($dataProvider);
    }

    /**
     * @return DataFrame[]
     */
    public function dataFrames(): array
    {
        return $this->frames;
    }
}
