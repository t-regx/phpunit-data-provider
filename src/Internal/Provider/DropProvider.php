<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class DropProvider extends DataProvider
{
    /** @var DataProvider */
    private $provider;
    /** @var int[] */
    private $columnIndices;

    public function __construct(DataProvider $provider, array $columnIndices)
    {
        $this->provider = $provider;
        $this->columnIndices = $columnIndices;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->provider->dataset() as $row) {
            $dataset[] = $row->set($this->droppedValues($row));
        }
        return $dataset;
    }

    private function droppedValues(DataRow $row): array
    {
        foreach ($this->columnIndices as $index) {
            unset($row->values[$this->positiveIndex($index, \count($row->values))]);
        }
        return \array_values($row->values);
    }

    private function positiveIndex(int $index, int $length): int
    {
        if ($index < 0) {
            return $index + $length;
        }
        return $index;
    }
}
