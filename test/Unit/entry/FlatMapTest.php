<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Executes;
use Test\Fixture\Functions;
use Test\Fixture\TestCase\TestCaseExactMessage;
use TRegx\PhpUnit\DataProviders\DataProvider;

class FlatMapTest extends TestCase
{
    use AssertsIteration, TestCaseExactMessage, Executes;

    /**
     * @test
     */
    public function shouldFlatMap()
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
        $this->assertIteratesValues($mapped, [
            ['joffrey'],
            ['BARATHEON'],
            ['cersei'],
            ['LANNISTER'],
            ['ilyn'],
            ['PAYNE'],
        ]);
    }

    /**
     * @test
     */
    public function shouldClear()
    {
        // given
        $provider = DataProvider::list('Joffrey', 'Cersei');
        // when
        $mapped = $provider->flatMap(Functions::constant([]));
        // then
        $this->assertIteratesValues($mapped, []);
    }

    /**
     * @test
     * @dataProvider invalidValues
     */
    public function shouldThrowForInvalidReturnType($value, string $name)
    {
        // given
        $mapped = DataProvider::tuples(['Valar', 'Morghulis'])
            ->flatMap(Functions::constant($value));
        // then
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Failed to flat map data rows. Expected array of rows, given: $name");
        // when
        $this->execute($mapped);
    }

    /**
     * @test
     * @dataProvider invalidValues
     */
    public function shouldThrowForInvalidElementType($value, string $name)
    {
        // given
        $mapped = DataProvider::tuples(['Valar', 'Morghulis'])
            ->flatMap(Functions::constant([$value]));
        // then
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Failed to flat map data rows. Expected array of arguments, given: $name");
        // when
        $this->execute($mapped);
    }

    public function invalidValues(): DataProvider
    {
        return DataProvider::tuples(
            ['invalid', "(string) 'invalid'"],
            [4, '(int) [4]'],
            [3.14, '(float) [3.14]'],
            [true, '(bool) true'],
            [new \stdClass(), '(object) \stdClass']
        );
    }

    /**
     * @test
     */
    public function shouldAcceptPhpCallable()
    {
        // given
        $tuples = DataProvider::tuples(
            [['J', 'o', 'f', 'f', 'r', 'e', 'y'], 2]
        );
        // when
        $mapped = $tuples->flatMap('array_chunk');
        // then
        $this->assertIteratesValues($mapped, [
            ['J', 'o'],
            ['f', 'f'],
            ['r', 'e'],
            ['y']
        ]);
    }

    /**
     * @test
     */
    public function shouldIgnoreKeysInReturnArray()
    {
        // given
        $provider = DataProvider::list('argument');
        // when
        $mapped = $provider->flatMap(Functions::constant(['key' => ['nested' => 'value']]));
        // then
        $this->assertIteratesValues($mapped, [
            ['value'],
        ]);
    }
}
