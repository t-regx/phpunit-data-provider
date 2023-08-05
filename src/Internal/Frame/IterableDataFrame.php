<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

use TRegx\PhpUnit\DataProviders\Internal\Type;
use TRegx\PhpUnit\DataProviders\MalformedDataProviderException;

class IterableDataFrame extends DataFrame
{
    /** @var iterable */
    private $dataProvider;
    /** @var IdempotentDataProviderIterator|null */
    private $cached = null;

    public function __construct(iterable $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function dataset(): array
    {
        $dataProvider = $this->cachedDataProvider();
        return $this->dataRows($dataProvider, !$dataProvider->sequential());
    }

    private function dataRows(iterable $dataProvider, bool $associative): array
    {
        $datasets = [];
        foreach ($dataProvider as $key => $values) {
            if (!\is_array($values)) {
                throw new MalformedDataProviderException(new Type($values));
            }
            $datasets[] = new DataRow([$key], [$associative], $values);
        }
        return $datasets;
    }

    private function cachedDataProvider(): IdempotentDataProviderIterator
    {
        if ($this->cached === null) {
            $this->cached = new IdempotentDataProviderIterator($this->dataProvider);
        }
        return $this->cached;
    }
}
