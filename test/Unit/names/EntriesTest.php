<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class EntriesTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldName()
    {
        $dictionary = DataProvider::entries([
            'Eddard'  => 'Stark',
            'Robert'  => 'Baratheon',
            'Balon'   => 'Greyjoy',
            'Rhaegar' => 'Targaryen',
        ]);
        $this->assertIteratesNames($dictionary, [
            "'Eddard', 'Stark'",
            "'Robert', 'Baratheon'",
            "'Balon', 'Greyjoy'",
            "'Rhaegar', 'Targaryen'",
        ]);
    }
}
