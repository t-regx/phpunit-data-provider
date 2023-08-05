<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\BrokenEncapsulationDataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\SequenceKey;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\ValueKey;

class DataRowModel
{
    /** @var BrokenEncapsulationDataProvider */
    private $dataProvider;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = new BrokenEncapsulationDataProvider($dataProvider);
    }

    /**
     * @return ViewRow[]
     */
    public function viewRows(): array
    {
        return $this->viewRowsReindexed($this->dataProvider->dataset());
    }

    /**
     * @param DataRow[] $dataRows
     * @return ViewRow[]
     */
    private function viewRowsReindexed(array $dataRows): array
    {
        $viewRows = [];
        foreach ($dataRows as $dataRow) {
            $viewRows[] = $this->viewRow($dataRow);
        }
        for ($i = 0; $i < \count($dataRows[0]->keys); $i++) {
            $sequence = 0;
            foreach ($viewRows as $row) {
                if (isset($row->keys[$i])) {
                    if ($row->keys[$i] instanceof SequenceKey) {
                        $row->keys[$i]->index = $sequence++;
                    }
                }
            }
        }
        return $viewRows;
    }

    private function viewRow(DataRow $dataRow): ViewRow
    {
        $keys = [];
        foreach ($dataRow->keys as $index => $key) {
            if ($dataRow->isAssociative($index)) {
                $keys[] = new ValueKey($key);
            } else {
                $keys[] = new SequenceKey();
            }
        }
        return new ViewRow($keys, $dataRow->values);
    }
}
