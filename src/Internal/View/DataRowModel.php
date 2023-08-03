<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\BrokenEncapsulationDataProvider;
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
        $sequence = 0;
        $viewRows = [];
        foreach ($this->dataProvider->dataset() as $dataRow) {
            if ($dataRow->isAssociative()) {
                $key = new ValueKey($dataRow->key);
            } else {
                $key = new SequenceKey($sequence++);
            }
            $viewRows[] = new ViewRow($key, $dataRow->values);
        }
        return $viewRows;
    }
}
