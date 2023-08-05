<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use Iterator;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;

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
        $dataProviders = $this->nonEmptyDataFrames();
        if (empty($dataProviders)) {
            return [];
        }
        return \iterator_to_array($this->cartesianProduct($dataProviders));
    }

    /**
     * @return DataFrame[]
     */
    private function nonEmptyDataFrames(): array
    {
        return \array_filter($this->inputProviders->dataFrames(), [$this, 'nonEmpty']);
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
