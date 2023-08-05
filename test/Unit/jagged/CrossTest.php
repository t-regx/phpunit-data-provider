<?php
namespace Test\Unit\jagged;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Executes;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\IrregularDataProviderException;

class CrossTest extends TestCase
{
    use Executes;

    /**
     * @test
     */
    public function shouldThrowForUnevenSetsOneTwo()
    {
        // when
        $dataProvider = DataProvider::cross([
            ['one'],
            ['one', 'two']
        ]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to cross data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowForUnevenSetsTwoOne()
    {
        // when
        $dataProvider = DataProvider::cross([
            ['one', 'two'],
            ['one'],
        ]);
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to cross data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }

    /**
     * @test
     */
    public function shouldThrowUnevenSetsMultiple()
    {
        // when
        $dataProvider = DataProvider::cross(
            [
                ['one', 'two'],
            ],
            [
                ['one'],
                ['one', 'two']
            ]
        );
        // then
        $this->expectException(IrregularDataProviderException::class);
        $this->expectExceptionMessage('Failed to cross data providers with different amounts of parameters in rows');
        // when
        $this->execute($dataProvider);
    }
}
