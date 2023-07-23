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
        $sequence = 0;
        foreach ($this->dataProvider->dataset() as $row) {
            if ($row->isAssociative()) {
                $key = is_int($row->key) ? "[$row->key]" : $row->key;
            } else {
                $key = '#' . $sequence++;
            }
            yield $key => $row->values;
        }
    }
}
