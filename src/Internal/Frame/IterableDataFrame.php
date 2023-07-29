<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

use TRegx\PhpUnit\DataProviders\MalformedDataProviderException;

class IterableDataFrame extends DataFrame
{
    /** @var iterable */
    private $dataProvider;

    public function __construct(iterable $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function dataset(): array
    {
        $datasets = [];
        $array = $this->array($this->dataProvider);
        $assoc = !$this->arraySequential($array);
        foreach ($array as $key => $values) {
            if (!\is_array($values)) {
                throw new MalformedDataProviderException();
            }
            $datasets[] = new DataRow([$key], [$assoc], $values);
        }
        return $datasets;
    }

    public function arraySequential(array $array): bool
    {
        return \array_keys($array) === \range(0, \count($array) - 1);
    }

    private function array(iterable $dataProvider): array
    {
        if (\is_array($dataProvider)) {
            return $dataProvider;
        }
        return \iterator_to_array($dataProvider);
    }
}
