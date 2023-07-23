<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\DataRow;

class ListProvider extends DataProvider
{
    /** @var mixed[] */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->values as $value) {
            $dataset[] = new DataRow($value, $value);
        }
        return $dataset;
    }
}
