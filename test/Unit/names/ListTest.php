<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class ListTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        // given
        $list = DataProvider::list('Joffrey', 'Cersei', 'Ilyn Payne', 'The Hound');
        // when, then
        $this->assertIteratesNames($list, ['Joffrey', 'Cersei', 'Ilyn Payne', 'The Hound']);
    }
}
