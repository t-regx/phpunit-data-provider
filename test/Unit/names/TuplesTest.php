<?php
namespace Test\Unit\names;

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
        // given
        $list = DataProvider::tuples(
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn Payne'],
            ['The Hound']
        );
        // when, then
        $this->assertIteratesNames($list, [
            "'Joffrey', 'Baratheon'",
            "'Cersei', 'Lannister'",
            'Ilyn Payne',
            'The Hound',
        ]);
    }
}
