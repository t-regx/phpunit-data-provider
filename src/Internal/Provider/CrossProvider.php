<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use Iterator;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;
use TRegx\PhpUnit\DataProviders\Internal\View\ReindexedDataFrame;
use TRegx\PhpUnit\DataProviders\IrregularDataProviderException;

class CrossProvider extends DataProvider
{
    /** @var InputProviders */
    private $inputProviders;

    public function __construct(array $dataProviders)
    {
        $this->inputProviders = new InputProviders($dataProviders);
    }

    protected function dataset(): array
    {
        $dataProviders = $this->nonEmptyReindexedFrames();
        if (empty($dataProviders)) {
            return [];
        }

        foreach ($this->inputProviders->dataFrames() as $frame) {
            if (!$this->frameUniform($frame)) {
                throw new IrregularDataProviderException('Failed to cross data providers with different amounts of parameters in rows');
            }
        }

        return \iterator_to_array($this->cartesianProduct($dataProviders));
    }

    private function frameUniform(DataFrame $frame): bool
    {
        $columns = new UniformSize();
        foreach ($frame->dataset() as $dataset) {
            $columns->next(\count($dataset->values));
        }
        return $columns->uniform();
    }

    /**
     * @return DataFrame[]
     */
    private function nonEmptyReindexedFrames(): array
    {
        $frames = [];
        foreach ($this->inputProviders->dataFrames() as $frame) {
            if ($this->nonEmpty($frame)) {
                $frames[] = new ReindexedDataFrame($frame);
            }
        }
        return $frames;
    }

    private function nonEmpty(DataFrame $dataProvider): bool
    {
        foreach ($dataProvider->dataset() as $value) {
            return true;
        }
        return false;
    }

    /**
     * @param DataFrame[] $dataProviders
     * @return DataRow[]|Iterator
     */
    private function cartesianProduct(array $dataProviders): \Iterator
    {
        /**
         * @var DataFrame|null $dataProvider
         */
        $dataProvider = \array_shift($dataProviders);
        if (empty($dataProviders)) {
            foreach ($dataProvider->dataset() as $row) {
                yield $this->toAssociative($row);
            }
        } else {
            foreach ($dataProvider->dataset() as $row) {
                foreach ($this->cartesianProduct($dataProviders) as $dataRow) {
                    yield $this->toAssociative($row)->joined($dataRow);
                }
            }
        }
    }

    private function toAssociative(DataRow $row): DataRow
    {
        return new DataRow(
            $row->keys,
            \array_fill(0, \count($row->keys), true),
            $row->values
        );
    }
}
