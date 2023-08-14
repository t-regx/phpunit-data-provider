<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Functions;
use TRegx\PhpUnit\DataProviders\DataProvider;

class FlatMapTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldName()
    {
        // given
        $provider = DataProvider::tuples(
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn', 'Payne']);
        // when
        $mapped = $provider->flatMap(function (string $name, string $lastName): array {
            return [
                [\strToLower($name)],
                [\strToUpper($lastName)]
            ];
        });
        // then
        $this->assertIteratesNames($mapped, [
            "'Joffrey', 'Baratheon', #0",
            "'Joffrey', 'Baratheon', #1",
            "'Cersei', 'Lannister', #2",
            "'Cersei', 'Lannister', #3",
            "'Ilyn', 'Payne', #4",
            "'Ilyn', 'Payne', #5",
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
        $mapped = $provider->flatMap(Functions::toNestedArray());
        // then
        $this->assertIteratesNames($mapped, [
            '[4], #0, #0',
            '[5], #1, #1'
        ]);
    }

    /**
     * @test
     */
    public function shouldFlatMapNameAssociative()
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
        $mapped = $provider->flatMap(Functions::constant(['key' => ['nested' => 'value']]));
        // then
        $this->assertIteratesNames($mapped, [
            "[4], #0, 'key'",
            "[5], #1, 'key'",
        ]);
    }

    /**
     * @test
     */
    public function shouldFlatMapNameAssociativeInteger()
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
        $mapped = $provider->flatMap(Functions::constant(['1' => [], '0' => []]));
        // then
        $this->assertIteratesNames($mapped, [
            "[4], #0, [1]",
            "[4], #1, [0]",
            "[5], #2, [1]",
            "[5], #3, [0]",
        ]);
    }
}
