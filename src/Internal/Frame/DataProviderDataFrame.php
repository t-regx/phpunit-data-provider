<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\BrokenEncapsulationDataProvider;

class DataProviderDataFrame extends DataFrame
{
    /** @var BrokenEncapsulationDataProvider */
    private $dataProvider;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = new BrokenEncapsulationDataProvider($dataProvider);
    }

    public function dataset(): array
    {
        return $this->dataProvider->dataset();
    }
}
