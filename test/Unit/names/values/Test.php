<?php
namespace Test\Unit\names\values;

use PHPUnit\Framework\TestCase;
use stdClass;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Fake\EmptyClass;
use Test\Fixture\Resources;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration, Resources;

    /**
     * @test
     * @dataProvider dataTypes
     */
    public function shouldNameDataTypes($value, string $name)
    {
        $this->assertIteratesNames(DataProvider::list($value), [$name]);
    }

    public function dataTypes(): DataProvider
    {
        return DataProvider::of([
            ['lorem ipsum', 'lorem ipsum'],
            [4, '[4]'],
            [3.14, '[3.14]'],
            [3.0, '[3.0]'],
            [true, 'true'],
            [false, 'false'],
            [null, 'null'],
            [[], 'array'],
            [new stdClass(), '\stdClass'],
            [new EmptyClass(), '\Test\Fixture\Fake\EmptyClass'],
            [function () {
            }, '\Closure'],
            ['strToUpper', 'strToUpper'], // callable string
            [$this->resource(), 'resource'],
        ]);
    }

    /**
     * @test
     * @dataProvider paddedStrings
     */
    public function shouldNameStrings(string $value, string $name)
    {
        $this->assertIteratesNames(DataProvider::list($value), [$name]);
    }

    public function paddedStrings(): DataProvider
    {
        return DataProvider::of([
            [' leading', "' leading'"],
            ['trailing ', "'trailing '"],
            [' surround ', "' surround '"],

            ["tab\ttab", 'tab\ttab'],
            ["new\nline", 'new\nline'],
            ["carriage\rreturn", 'carriage\rreturn'],
            ["form\ffeed", 'form\ffeed'],
            ["vertical\vtab", 'vertical\vtab'],

            ['4', "'4'"],
            ['123', "'123'"],
            ['k2', 'k2'],
            ['2forU', '2forU'],
            ["123\n", "'123\\n'"],
        ]);
    }
}
