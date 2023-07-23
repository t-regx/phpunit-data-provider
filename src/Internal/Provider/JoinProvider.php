<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\DataRow;

class JoinProvider extends DataProvider
{
    /** @var array */
    private $dataProviders;

    public function __construct(array $dataProviders)
    {
        $this->dataProviders = $dataProviders;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->dataProviders as $dataProvider) {
            foreach ($dataProvider as $key => $values) {
                $dataset[] = new DataRow($key, !$this->sequential($dataProvider), $values);
            }
        }
        return $dataset;
    }

    private function sequential(array $array): bool
    {
        return \array_keys($array) === range(0, \count($array) - 1);
    }
}
