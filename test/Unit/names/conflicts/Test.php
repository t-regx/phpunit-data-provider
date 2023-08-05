<?php
namespace Test\Unit\names\conflicts;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Resources;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration, Resources;

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesNull()
    {
        $this->assertIteratesNames(
            DataProvider::list(null, 'null'),
            ['(null)', "(string) 'null'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesTrue()
    {
        $this->assertIteratesNames(
            DataProvider::list(true, 'true'),
            ['(bool) true', "(string) 'true'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesFalse()
    {
        $this->assertIteratesNames(
            DataProvider::list(false, 'false'),
            ['(bool) false', "(string) 'false'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesArray()
    {
        $this->assertIteratesNames(
            DataProvider::list([], 'array'),
            ['(array)', "(string) 'array'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesInt()
    {
        $this->assertIteratesNames(
            DataProvider::list(4, '4'),
            ['[4]', "'4'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesFloat()
    {
        $this->assertIteratesNames(
            DataProvider::list(4.0, '4.0'),
            ['(float) [4.0]', "(string) '4.0'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesCallable()
    {
        $callable = function () {
        };
        $this->assertIteratesNames(
            DataProvider::list($callable, 'callable'),
            ['(object) \Closure', "(string) 'callable'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesObject()
    {
        $this->assertIteratesNames(
            DataProvider::list(new \stdClass(), 'object'),
            ['(object) \stdClass', "(string) 'object'"]);

        $this->assertIteratesNames(
            DataProvider::list(new \stdClass(), '\stdClass'),
            ['(object) \stdClass', "(string) '\stdClass'"]);
    }

    /**
     * @test
     */
    public function shouldDifferentiateSimilarNamesResource()
    {
        $this->assertIteratesNames(
            DataProvider::list($this->resource(), 'resource'),
            ['(resource)', "(string) 'resource'"]);
    }
}
