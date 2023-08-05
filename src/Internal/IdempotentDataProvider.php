<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;

class IdempotentDataProvider extends DataProvider
{
    /** @var DataProvider */
    private $dataProvider;
    /** @var DataFrame[]|null */
    private $cached = null;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function dataset(): array
    {
        if ($this->cached === null) {
            $this->cached = $this->dataProvider->dataset();
        }
        return $this->cached;
    }
}
