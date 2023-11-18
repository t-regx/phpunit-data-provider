<?php
namespace Test\Fixture;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class HistoryDataProvider extends DataProvider
{
    /** @var mixed[] */
    private $elements;
    /** @var int */
    public $calls = 0;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    protected function dataset(): array
    {
        $this->calls++;
        return $this->arrayDatasets();
    }

    /**
     * @return DataRow[]
     */
    private function arrayDatasets(): array
    {
        $datasets = [];
        foreach ($this->elements as $key => $value) {
            $datasets[] = DataRow::dictionaryEntry($key, $value);
        }
        return $datasets;
    }
}
