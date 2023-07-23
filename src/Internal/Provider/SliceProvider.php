<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;

class SliceProvider extends DataProvider
{
    /** @var DataProvider */
    private $provider;
    /** @var int */
    private $start;
    /** @var int|null */
    private $count;

    public function __construct(DataProvider $provider, int $start, ?int $count)
    {
        $this->provider = $provider;
        $this->start = $start;
        $this->count = $count;
    }

    protected function dataset(): array
    {
        return \array_slice($this->provider->dataset(), $this->start, $this->count);
    }
}
