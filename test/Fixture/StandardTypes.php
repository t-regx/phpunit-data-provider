<?php
namespace Test\Fixture;

use TRegx\PhpUnit\DataProviders\DataProvider;

trait StandardTypes
{
    public function standardTypes(): DataProvider
    {
        return DataProvider::tuples(
            [4, '(int) [4]'],
            [4.0, '(float) [4.0]'],
            [null, '(null)'],
            ['text', "(string) 'text'"],
            [new \stdClass(), '(object) \stdClass'],
            [function () {
            }, '(object) \Closure']
        );
    }
}
