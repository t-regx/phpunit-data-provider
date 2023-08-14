<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\IterableDataFrame;

class FlatMapProvider extends DataProvider
{
    /** @var DataProvider */
    private $provider;
    /** @var Mapper */
    private $flatMapper;

    public function __construct(DataProvider $provider, callable $mapper)
    {
        $this->provider = $provider;
        $this->flatMapper = new FlatMapper($mapper);
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->provider->dataset() as $dataRow) {
            $frame = new IterableDataFrame($this->flatMapper->apply($dataRow->values));
            foreach ($frame->dataset() as $row) {
                $dataset[] = $dataRow->joined($row)->set($row->values);
            }
        }
        return $dataset;
    }
}
