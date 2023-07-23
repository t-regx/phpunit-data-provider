<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

use TRegx\PhpUnit\DataProviders\DataProvider;

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
        foreach ($this->dataProvider->dataset() as $row) {
            yield $row->key => [$row->value];
        }
    }
}
