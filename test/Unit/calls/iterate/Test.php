<?php
namespace Test\Unit\calls\iterate;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Assertion\AssertsIteratorCalls;
use Test\Fixture\Executes;
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
     */
    public function shouldIterateOnceNested()
    {
        // given
        $iterator = new HistoryIterator([['value']]);
        $shared = DataProvider::of($iterator);
        // when
        $this->execute(DataProvider::join($shared, $shared));
        // then
        $this->assertSingleIteration($iterator, 1);
    }

    public function providers(): DataProvider
    {
        return DataProvider::dictionary([
            'of'    => function (HistoryIterator $iterator): DataProvider {
                return DataProvider::of($iterator);
            },
            'join'  => function (HistoryIterator $iterator): DataProvider {
                return DataProvider::join($iterator, [['value']]);
            },
            'zip'   => function (HistoryIterator $iterator): DataProvider {
                return DataProvider::zip($iterator, [['value']]);
            },
            'cross' => function (HistoryIterator $iterator): DataProvider {
                return DataProvider::cross($iterator, [['value']]);
            },
        ]);
    }
}
