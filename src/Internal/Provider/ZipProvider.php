<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class ZipProvider extends DataProvider
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
        for ($i = 0; $i < \count($this->dataProviders[0]); $i++) {
            $keys = [];
            $assocs = [];
            $values = [];
            foreach ($this->dataProviders as $dataProvider) {
                $key = \array_keys($dataProvider)[$i];
                $keys[] = $key;
                $assocs[] = !$this->sequential($dataProvider);
                $values[] = $dataProvider[$key];
            }
            $dataset[] = new DataRow($keys, $assocs, \array_merge(...$values));
        }
        return $dataset;
    }

    private function sequential(array $array): bool
    {
        return \array_keys($array) === range(0, \count($array) - 1);
    }
}
