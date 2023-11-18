<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;
use TRegx\PhpUnit\DataProviders\IrregularDataProviderException;

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
        if (!$this->framesRowsUniform()) {
            throw new IrregularDataProviderException('Failed to zip data providers with different amounts of rows');
        }
        foreach ($this->dataFrames as $frame) {
            if (!$this->frameColumnsUniform($frame)) {
                throw new IrregularDataProviderException('Failed to zip data providers with different amounts of parameters in rows');
            }
        }
        return $this->zippedRows();
    }

    private function framesRowsUniform(): bool
    {
        $rows = new UniformSize();
        foreach ($this->dataFrames as $frame) {
            $rows->next(\count($frame->dataset()));
        }
        return $rows->uniform();
    }

    private function frameColumnsUniform(DataFrame $frame): bool
    {
        $columns = new UniformSize();
        foreach ($frame->dataset() as $row) {
            $columns->next(\count($row->values));
        }
        return $columns->uniform();
    }

    private function zippedRows(): array
    {
        $dataset = [];
        for ($i = 0; $i < $this->count(); $i++) {
            $dataset[] = $this->zippedRow($i);
        }
        return $dataset;
    }

    private function count(): int
    {
        return \count($this->dataFrames[0]->dataset());
    }

    private function zippedRow(int $rowIndex): DataRow
    {
        $joinedRow = DataRow::of([]);
        foreach ($this->dataFrames as $dataProvider) {
            $joinedRow = $joinedRow->joined($dataProvider->dataset()[$rowIndex]);
        }
        return $joinedRow;
    }
}
