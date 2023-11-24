<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class ReindexedKeysDataFrame extends DataFrame
{
    /** @var DataFrame */
    private $frame;

    public function __construct(DataFrame $frame)
    {
        $this->frame = $frame;
    }

    public function dataset(): array
    {
        $dataset = $this->frame->dataset();
        if (empty($dataset)) {
            return [];
        }
        return $this->reindexedRows($dataset);
    }

    /**
     * @param DataRow[] $dataRows
     * @return DataRow[]
     */
    private function reindexedRows(array $dataRows): array
    {
        foreach ($this->columnIndices($dataRows) as $columnIndex) {
            $this->reindexColumn($dataRows, $columnIndex);
        }
        return $dataRows;
    }

    /**
     * @param DataRow[] $dataRows
     * @return \Iterator
     */
    private function columnIndices(array $dataRows): iterable
    {
        return \range(0, $this->widestRowWidth($dataRows));
    }

    /**
     * @param DataRow[] $dataRows
     * @return int
     */
    private function widestRowWidth(array $dataRows): int
    {
        return max(\array_map(function (DataRow $row): int {
            return \count($row->keys);
        }, $dataRows));
    }

    /**
     * @param DataRow[] $dataRows
     * @param int $columnIndex
     * @return void
     */
    private function reindexColumn(array $dataRows, int $columnIndex): void
    {
        $sequence = 0;
        foreach ($this->rowsWithSequentialKeyAt($dataRows, $columnIndex) as $row) {
            $row->keys[$columnIndex] = $sequence++;
        }
    }

    /**
     * @param DataRow[] $dataRows
     * @param int $index
     * @return \Iterator
     */
    private function rowsWithSequentialKeyAt(array $dataRows, int $index): \Iterator
    {
        foreach ($dataRows as $row) {
            if (!isset($row->keys[$index])) {
                continue;
            }
            if ($row->isAssociative($index)) {
                continue;
            }
            yield $row;
        }
    }
}
