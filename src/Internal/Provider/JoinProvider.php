<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;

class JoinProvider extends DataProvider
{
    /** @var InputProviders */
    private $inputProviders;

    public function __construct(array $dataProviders)
    {
        $this->inputProviders = new InputProviders($dataProviders);
    }

    protected function dataset(): array
    {
        $dataset = [];
        foreach ($this->inputProviders->dataFrames() as $dataProvider) {
            foreach ($dataProvider->dataset() as $row) {
                $dataset[] = $row;
            }
        }
        return $dataset;
    }
}
