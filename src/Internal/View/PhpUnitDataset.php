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
        $sequence = 0;
        foreach ($rows as $row) {
            yield $this->formatKeys($row, $keyset, $sequence) => $row->values;
        }
    }

    private function formatKeys(ViewRow $row, ViewRowKeyset $keyset, int &$sequence): string
    {
        if ($keyset->isDuplicate($row)) {
            return $row->formatKeys(true) . ' !' . $sequence++;
        }
        return $row->formatKeys(false);
    }
}
