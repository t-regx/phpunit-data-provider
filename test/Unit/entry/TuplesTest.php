<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class TuplesTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        $list = DataProvider::tuples(
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn Payne'],
            ['The Hound']
        );
        $this->assertIteratesValues($list, [
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn Payne'],
            ['The Hound'],
        ]);
    }
}
