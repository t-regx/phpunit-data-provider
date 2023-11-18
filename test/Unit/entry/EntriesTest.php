<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class EntriesTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        $dictionary = DataProvider::entries([
            'Eddard'  => 'Stark',
            'Robert'  => 'Baratheon',
            'Balon'   => 'Greyjoy',
            'Rhaegar' => 'Targaryen',
        ]);
        $this->assertIteratesValues($dictionary, [
            ['Eddard', 'Stark'],
            ['Robert', 'Baratheon'],
            ['Balon', 'Greyjoy'],
            ['Rhaegar', 'Targaryen'],
        ]);
    }
}
