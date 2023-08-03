<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\BrokenEncapsulationDataProvider;

class PhpUnitDataset implements \IteratorAggregate
{
    /** @var BrokenEncapsulationDataProvider */
    private $dataProvider;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = new BrokenEncapsulationDataProvider($dataProvider);
    }

    public function getIterator()
    {
        $rows = new DataRowModel($this->dataProvider);
        foreach ($rows->viewRows() as $row) {
            yield $row->key->toString(false) => $row->values;
        }
    }
}
