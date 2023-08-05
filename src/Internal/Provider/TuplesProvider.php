<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class TuplesProvider extends DataProvider
{
    /** @var array[] */
    private $sets;

    public function __construct(array $sets)
    {
        $this->sets = $sets;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->sets as $set) {
            $dataset[] = new DataRow($set, \array_fill(0, \count($set), true), $set);
        }
        return $dataset;
    }
}
