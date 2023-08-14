<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class MapProvider extends DataProvider
{
    /** @var DataProvider */
    private $provider;
    /** @var Mapper */
    private $mapper;

    public function __construct(DataProvider $provider, callable $mapper)
    {
        $this->provider = $provider;
        $this->mapper = new Mapper($mapper);
    }

    protected function dataset(): array
    {
        return \array_map([$this, 'mapped'], $this->provider->dataset());
    }

    private function mapped(DataRow $row): DataRow
    {
        return $row->set($this->mapper->apply($row->values));
    }
}
