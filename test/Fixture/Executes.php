<?php
namespace Test\Fixture;

use TRegx\PhpUnit\DataProviders\DataProvider;

trait Executes
{
    public function execute(DataProvider $dataProvider): void
    {
        \iterator_to_array($dataProvider);
    }
}
