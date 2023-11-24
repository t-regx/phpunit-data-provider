<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataProviderDataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\KeyTypes;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\SequenceKey;
use TRegx\PhpUnit\DataProviders\Internal\View\Key\ValueKey;

class DataRowModel
{
    /** @var DataFrame */
    private $dataProvider;
    /** @var KeyTypes */
    private $keyTypes;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = new DataProviderDataFrame($dataProvider);
        $this->keyTypes = new KeyTypes($this->dataProvider);
    }

    /**
     * @return ViewRow[]
     */
    public function viewRows(): array
    {
        return $this->viewRowsMappedKeys(new ReindexedKeysDataFrame($this->dataProvider));
    }

    /**
     * @param DataFrame $frame
     * @return ViewRow[]
     */
    private function viewRowsMappedKeys(DataFrame $frame): array
    {
        $viewRows = [];
        foreach ($frame->dataset() as $dataRow) {
            $viewRows[] = $this->viewRow($dataRow);
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
                $keys[] = new SequenceKey($key);
            }
        }
        return new ViewRow($keys, $dataRow->values);
    }

    public function uniformTypes(): bool
    {
        return $this->keyTypes->uniformTypes();
    }
}
