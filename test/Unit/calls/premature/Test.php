<?php
namespace Test\Unit\calls\premature;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\TestCase\TestCasePasses;
use Test\Fixture\ThrowDataProvider;
use Test\Fixture\ThrowIterable;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use TestCasePasses, AssertsIteration;

    /**
     * @test
     * @dataProvider throwIterables
     */
    public function shouldNotIterateBeforeExecutionOf(iterable $throwIterable)
    {
        // when
        DataProvider::of($throwIterable);
        // then
        $this->pass();
    }

    /**
     * @test
     * @dataProvider throwIterables
     */
    public function shouldNotIterateBeforeExecutionJoin(iterable $throwIterable)
    {
        // when
        DataProvider::join($throwIterable);
        // then
        $this->pass();
    }

    /**
     * @test
     * @dataProvider throwIterables
     */
    public function shouldNotIterateBeforeExecutionCross(iterable $throwIterable)
    {
        // when
        DataProvider::cross($throwIterable);
        // then
        $this->pass();
    }

    /**
     * @test
     * @dataProvider throwIterables
     */
    public function shouldNotIterateBeforeExecutionZip(iterable $throwIterable)
    {
        // when
        DataProvider::zip($throwIterable);
        // then
        $this->pass();
    }

    public function throwIterables(): DataProvider
    {
        return DataProvider::list(
            new ThrowIterable(),
            new ThrowDataProvider()
        );
    }
}
