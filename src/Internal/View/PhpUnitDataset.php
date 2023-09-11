<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\View\Duplicates\ViewRowKeyset;

class PhpUnitDataset implements \IteratorAggregate
{
    /** @var DataRowModel */
    private $model;

    public function __construct(DataProvider $dataProvider)
    {
        $this->model = new DataRowModel($dataProvider);
    }

    public function getIterator(): \Iterator
    {
        return $this->dataRows($this->model->viewRows());
    }

    /**
     * @param ViewRow[] $rows
     */
    private function dataRows(array $rows): \Iterator
    {
        $keyset = new ViewRowKeyset($rows);
        foreach ($rows as $index => $row) {
            yield $this->formatKeys($row, $keyset, !$this->model->uniformTypes(), $index) => $row->values;
        }
    }

    private function formatKeys(ViewRow $row, ViewRowKeyset $keyset, bool $includeType, int $index): string
    {
        if ($keyset->isDuplicate($row)) {
            return $row->formatKeys(true, $includeType) . ' !' . $index;
        }
        return $row->formatKeys(false, $includeType);
    }
}
