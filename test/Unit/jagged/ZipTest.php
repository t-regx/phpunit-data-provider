<?php
namespace Test\Unit\jagged;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Executes;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\IrregularDataProviderException;

class ZipTest extends TestCase
{
    use AssertsIteration, Executes;

    /**
     * @test
     */
    public function shouldThrowForUnevenSetsOneTwo()
    {
        // when
        $dataProvider = DataProvider::zip([
            ['one'],
            ['one', 'two'],
        ]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to zip data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowForUnevenSetsTwoOne()
    {
        // when
        $dataProvider = DataProvider::zip([
            ['one', 'two'],
            ['one'],
        ]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to zip data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowUnevenSetsMultiple()
    {
        // when
        $dataProvider = DataProvider::zip(
            [
                ['one', 'two', 'three'],
                ['one', 'two'],
            ],
            [
                ['one'],
                ['one', 'two'],
            ]
        );
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to zip data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowForUnevenRowsFirstTwo()
    {
        // when
        $dataProvider = DataProvider::zip([], [['value']]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to zip data providers with different amounts of rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowForUnevenRowsLastRow()
    {
        // when
        $value = [['value']];
        $dataProvider = DataProvider::zip($value, $value, $value, [['one'], ['two']]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to zip data providers with different amounts of rows');
        // when
        $this->execute($dataProvider);
    }
}
