<?php
namespace Test\Unit\names\types;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Resources;
use Test\Fixture\TestCase\TestCaseConditional;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration, Resources, TestCaseConditional;

    /**
     * @test
     * @dataProvider dataTypesCrossed
     */
    public function shouldNameTypes($first, $firstName, $second, $secondName)
    {
        if ($firstName === $secondName) {
            $this->markTestUnnecessary('Types are specified for different types');
        }
        $this->assertIteratesNames(
            DataProvider::zip(DataProvider::list($first), DataProvider::list($second)),
            ["$firstName, $secondName"]);
    }

    public function dataTypesCrossed(): DataProvider
    {
        return DataProvider::cross($this->dataTypes(), $this->dataTypes());
    }

    public function dataTypes(): DataProvider
    {
        return DataProvider::of([
            'int'      => [4, '(int) [4]'],
            'float'    => [4.0, '(float) [4.0]'],
            'null'     => [null, '(null)'],
            'bool'     => [true, '(bool) true'],
            'array'    => [[], '(array)'],
            'object'   => [new \stdClass(), '(object) \stdClass'],
            'resource' => [$this->resource(), '(resource)'],
        ]);
    }

    /**
     * @test
     */
    public function shouldNotIncludeArrayKeyTypes()
    {
        $this->assertIteratesNames(
            DataProvider::list('foo', 4, 'bar', 5),
            ['foo', '[4]', 'bar', '[5]']);
    }

    /**
     * @test
     */
    public function shouldNotIncludeObjectClosure()
    {
        $provider = DataProvider::list(
            new \stdClass(),
            function () {
            });
        $this->assertIteratesNames($provider, ['\stdClass', '\Closure']);
    }
}
