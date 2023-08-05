<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;

class ZipProvider extends DataProvider
{
    /** @var InputProviders */
    private $inputProviders;
    /** @var DataFrame[] */
    private $dataFrames;

    public function __construct(array $dataProviders)
    {
        $this->inputProviders = new InputProviders($dataProviders);
        $this->dataFrames = $this->inputProviders->dataFrames();
    }

    protected function dataset(): array
    {
        $dataset = [];
        for ($i = 0; $i < $this->count(); $i++) {
            $dataset[] = $this->zippedRow($i);
        }
        return $dataset;
    }

    private function zippedRow(int $index): DataRow
    {
        $joinedRow = DataRow::empty();
        foreach ($this->dataFrames as $dataProvider) {
            $joinedRow = $joinedRow->joined($dataProvider->dataset()[$index]);
        }
        return $joinedRow;
    }

    private function count(): int
    {
        return \count($this->dataFrames[0]->dataset());
    }
}
