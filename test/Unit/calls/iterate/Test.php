<?php
namespace Test\Unit\calls\iterate;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Assertion\AssertsIteratorCalls;
use Test\Fixture\Executes;
use Test\Fixture\HistoryDataProvider;
use Test\Fixture\HistoryIterator;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration, Executes, AssertsIteratorCalls;

    /**
     * @test
     * @dataProvider providers
     */
    public function shouldIterateOnce(callable $provider)
    {
        // given
        $iterator = new HistoryIterator([['value']]);
        $dataProvider = $provider($iterator);
        // when
        $this->execute($dataProvider);
        $this->execute($dataProvider);
        // then
        $this->assertSingleIteration($iterator, 1);
    }

    /**
     * @test
     * @dataProvider providers
     */
    public function shouldIterateOnceNested(callable $provider)
    {
        // given
        $iterator = new HistoryIterator([['value']]);
        $shared = DataProvider::of($iterator);
        // when
        $this->execute($provider($shared, $shared));
        // then
        $this->assertSingleIteration($iterator, 1);
    }

    public function providers(): DataProvider
    {
        return DataProvider::dictionary([
            'of'    => function (iterable $iterable): DataProvider {
                return DataProvider::of($iterable);
            },
            'join'  => function (iterable $iterable): DataProvider {
                return DataProvider::join($iterable, [['value']]);
            },
            'zip'   => function (iterable $iterable): DataProvider {
                return DataProvider::zip($iterable, [['value']]);
            },
            'cross' => function (iterable $iterable): DataProvider {
                return DataProvider::cross($iterable, [['value']]);
            },
        ]);
    }

    /**
     * @test
     */
    public function shouldIterateOnceDataProvider()
    {
        // given
        $provider = new HistoryDataProvider(['one', 'two']);
        // when
        $this->execute(DataProvider::zip($provider));
        // then
        $this->assertSingleIterationProvider($provider);
    }
}
