<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class OfTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function test()
    {
        $identity = DataProvider::of([
            'Winterfell'  => ['Stark', 'Eddard'],
            "Storm's End" => ['Baratheon', 'Robert'],
            "Pyke"        => ['Balon', 'Greyjoy'],
            "Dragonstone" => ['Rhaegar', 'Targaryen'],
        ]);
        $this->assertIteratesNames($identity, [
            'Winterfell',
            "Storm's End",
            "Pyke",
            "Dragonstone",
        ]);
    }

    /**
     * @test
     */
    public function shouldNameAssociativeInteger()
    {
        $identity = DataProvider::of([
            0 => ['Eddard'],
            1 => ['Robert'],
            3 => ['Greyjoy'],
            4 => ['Targaryen'],
        ]);
        $this->assertIteratesNames($identity, ['[0]', '[1]', '[3]', '[4]']);
    }

    /**
     * @test
     */
    public function shouldNameSequential()
    {
        $identity = DataProvider::of([['Eddard'], ['Robert'], ['Greyjoy'], ['Targaryen'],]);
        $this->assertIteratesNames($identity, ['#0', '#1', '#2', '#3']);
    }
}
