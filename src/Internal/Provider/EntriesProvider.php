<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class EntriesProvider extends DataProvider
{
    /** @var mixed[] */
    private $dictionary;

    public function __construct(array $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->dictionary as $key => $value) {
            $dataset[] = new DataRow([$key, $value], [true, true], [$key, $value]);
        }
        return $dataset;
    }
}
