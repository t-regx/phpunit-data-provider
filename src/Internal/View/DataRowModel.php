<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\BrokenEncapsulationDataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataProviderDataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\KeyTypes;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\SequenceKey;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\ValueKey;

class DataRowModel
{
    /** @var BrokenEncapsulationDataProvider */
    private $dataProvider;
    /** @var KeyTypes */
    private $keyTypes;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = new BrokenEncapsulationDataProvider($dataProvider);
        $this->keyTypes = new KeyTypes(new DataProviderDataFrame($this->dataProvider));
    }

    /**
     * @return ViewRow[]
     */
    public function viewRows(): array
    {
        $dataset = $this->dataProvider->dataset();
        if (empty($dataset)) {
            return [];
        }
        return $this->viewRowsReindexed($dataset);
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

    public function uniformTypes(): bool
    {
        return $this->keyTypes->uniformTypes();
    }
}
