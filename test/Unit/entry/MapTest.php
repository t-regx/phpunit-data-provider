<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Executes;
use Test\Fixture\Functions;
use Test\Fixture\TestCase\TestCaseExactMessage;
use TRegx\PhpUnit\DataProviders\DataProvider;

class MapTest extends TestCase
{
    use AssertsIteration, TestCaseExactMessage, Executes;

    /**
     * @test
     */
    public function shouldMap()
    {
        // given
        $provider = DataProvider::tuples(
            ['Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister'],
            ['Ilyn', 'Payne'],
            ['Sandor', 'Clegane']);
        // when
        $mapped = $provider->map(function (string $name, string $lastName): array {
            return [
                \strToLower($name),
                \strToUpper($lastName)
            ];
        });
        // then
        $this->assertIteratesValues($mapped, [
            ['joffrey', 'BARATHEON'],
            ['cersei', 'LANNISTER'],
            ['ilyn', 'PAYNE'],
            ['sandor', 'CLEGANE'],
        ]);
    }

    /**
     * @test
     * @dataProvider invalidValues
     */
    public function shouldThrow($value, string $name)
    {
        // given
        $mapped = DataProvider::tuples(['Valar', 'Morghulis'])
            ->map(Functions::constant($value));
        // then
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Failed to map data row as array, given: $name");
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
            ['Joffrey'],
            ['Cersei'],
            ['Ilyn Payne']);
        // when
        $mapped = $tuples->map('str_split');
        // then
        $this->assertIteratesValues($mapped, [
            ['J', 'o', 'f', 'f', 'r', 'e', 'y'],
            ['C', 'e', 'r', 's', 'e', 'i'],
            ['I', 'l', 'y', 'n', ' ', 'P', 'a', 'y', 'n', 'e'],
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
        $mapped = $provider->map(Functions::constant(['key' => 'value']));
        // then
        $this->assertIteratesValues($mapped, [
            ['value'],
        ]);
    }
}
