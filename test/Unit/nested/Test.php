<?php
namespace Test\Unit\nested;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldAcceptDataProvider()
    {
        $provider = DataProvider::of(DataProvider::list('Eddard', 'Robert'));
        $this->assertIterates($provider, [
            'Eddard' => ['Eddard'],
            'Robert' => ['Robert'],
        ]);
    }

    /**
     * @test
     */
    public function shouldJoinZipAndOf()
    {
        // when
        $joined = DataProvider::join(
            DataProvider::zip(
                DataProvider::list('Eddard', 'Robert'),
                DataProvider::list('Stark', 'Baratheon')),
            DataProvider::of([
                ['Balon', 'Greyjoy'],
                ['Tywin', 'Lannister']]));
        // then
        $this->assertIterates($joined, [
            "'Eddard', 'Stark'"     => ['Eddard', 'Stark'],
            "'Robert', 'Baratheon'" => ['Robert', 'Baratheon'],
            '#0'                    => ['Balon', 'Greyjoy'],
            '#1'                    => ['Tywin', 'Lannister'],
        ]);
    }

    /**
     * @test
     */
    public function shouldJoinZips()
    {
        // when
        $joined = DataProvider::join(
            DataProvider::zip(
                DataProvider::of([0 => ['Eddard'], 1 => ['Robert']]),
                DataProvider::list('Stark', 'Baratheon')),
            DataProvider::zip(
                DataProvider::of([0 => ['Balon'], 1 => ['Tywin']]),
                DataProvider::of([0 => ['Greyjoy'], 1 => ['Lannister']])
            ));
        // then
        $this->assertIterates($joined, [
            "#0, 'Stark'"     => ['Eddard', 'Stark'],
            "#1, 'Baratheon'" => ['Robert', 'Baratheon'],
            "#2, #0"          => ['Balon', 'Greyjoy'],
            "#3, #1"          => ['Tywin', 'Lannister'],
        ]);
    }

    /**
     * @test
     */
    public function shouldSequenceColumns()
    {
        $provider = DataProvider::zip(
            [['Eddard'], ['Jon'], ['Arya']],
            [['Stark'], ['Snow'], ['Stark']]);
        $this->assertIteratesNames($provider, [
            '#0, #0',
            '#1, #1',
            '#2, #2'
        ]);
    }
}
