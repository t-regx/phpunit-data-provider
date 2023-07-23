<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class OfTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        $identity = DataProvider::of([
            'Winterfell'  => ['Stark', 'Eddard'],
            "Storm's End" => ['Baratheon', 'Robert'],
            "Pyke"        => ['Balon', 'Greyjoy'],
            "Dragonstone" => ['Rhaegar', 'Targaryen'],
        ]);
        $this->assertIteratesValues($identity, [
            ['Stark', 'Eddard'],
            ['Baratheon', 'Robert'],
            ['Balon', 'Greyjoy'],
            ['Rhaegar', 'Targaryen'],
        ]);
    }
}
