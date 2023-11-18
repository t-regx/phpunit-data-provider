<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class DistinctPairsProvider extends DataProvider
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
        foreach ($this->values as $index1 => $augend) {
            foreach ($this->values as $index2 => $addend) {
                if ($index1 === $index2) {
                    continue;
                }
                $dataset[] = DataRow::of([$augend, $addend]);
            }
        }
        return $dataset;
    }
}
