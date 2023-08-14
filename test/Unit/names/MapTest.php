<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Functions;
use TRegx\PhpUnit\DataProviders\DataProvider;

class MapTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldName()
    {
        // given
        $list = DataProvider::tuples(
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn', 'Payne'],
            ['Sandor', 'Clegane']);
        // when
        $mapped = $list->map(Functions::constant([]))->map(Functions::constant([]));
        // then
        $this->assertIteratesNames($mapped, [
            "'Joffrey', 'Baratheon'",
            "'Cersei', 'Lannister'",
            "'Ilyn', 'Payne'",
            "'Sandor', 'Clegane'",
        ]);
    }

    /**
     * @test
     */
    public function shouldNameAssociative()
    {
        // given
        $provider = DataProvider::zip(
            DataProvider::of([
                '4' => ['Joffrey', 'Baratheon'],
                '5' => ['Cersei', 'Lannister']]),
            DataProvider::of([
                ['Ilyn', 'Payne'],
                ['Sandor', 'Clegane']]));
        // when
        $mapped = $provider->map(Functions::toArray());
        // then
        $this->assertIteratesNames($mapped, ['[4], #0', '[5], #1']);
    }
}
