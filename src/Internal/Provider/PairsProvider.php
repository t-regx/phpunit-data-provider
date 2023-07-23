<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class PairsProvider extends DataProvider
{
    /** @var mixed[] */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->values as $augend) {
            foreach ($this->values as $addend) {
                $dataset[] = new DataRow([$augend, $addend], [true, true], [$augend, $addend]);
            }
        }
        return $dataset;
    }
}
