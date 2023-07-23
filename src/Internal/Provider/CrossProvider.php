<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use Iterator;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class CrossProvider extends DataProvider
{
    /** @var array[] */
    private $dataProviders;

    public function __construct(array $dataProviders)
    {
        $this->dataProviders = $dataProviders;
    }

    protected function dataset(): array
    {
        $dataProviders = \array_filter($this->dataProviders);
        if (empty($dataProviders)) {
            return [];
        }
        return \iterator_to_array($this->cartesianProduct($dataProviders));
    }

    /**
     * @return DataRow[]|Iterator
     */
    private function cartesianProduct(array $dataProviders): \Iterator
    {
        $dataProvider = \array_shift($dataProviders);
        if (empty($dataProviders)) {
            foreach ($dataProvider as $key => $row) {
                yield new DataRow([$key], [true], $row);
            }
        } else {
            foreach ($dataProvider as $key => $values) {
                foreach ($this->cartesianProduct($dataProviders) as $dataRow) {
                    yield DataRow::associative($key, $values)->joined($dataRow);
                }
            }
        }
    }
}
