<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\DataRow;

class IdentityProvider extends DataProvider
{
    /** @var mixed[] */
    private $dataProvider;

    public function __construct(array $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->dataProvider as $key => $values) {
            $dataset[] = new DataRow($key, !$this->sequential(), $values);
        }
        return $dataset;
    }

    private function sequential(): bool
    {
        return \array_keys($this->dataProvider) === range(0, \count($this->dataProvider) - 1);
    }
}
