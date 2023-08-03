<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;

class JoinProvider extends DataProvider
{
    /** @var array */
    private $dataProviders;

    public function __construct(array $dataProviders)
    {
        $this->dataProviders = $dataProviders;
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->dataProviders as $dataProvider) {
            $frame = new DataFrame($dataProvider);
            foreach ($frame->dataset() as $row) {
                $dataset[] = $row;
            }
        }
        return $dataset;
    }
}
