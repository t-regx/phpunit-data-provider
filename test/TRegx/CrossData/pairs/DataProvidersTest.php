<?php
namespace TRegx\CrossData\pairs;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TRegx\CrossData\DataProviders;

class DataProvidersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetMixedPairs()
    {
        // when
        $result = DataProviders::pairs('one', 'two', 'three', 'four');

        // then
        $this->assertEquals([
            ['one', 'one'],
            ['one', 'two'],
            ['one', 'three'],
            ['one', 'four'],

            ['two', 'one'],
            ['two', 'two'],
            ['two', 'three'],
            ['two', 'four'],

            ['three', 'one'],
            ['three', 'two'],
            ['three', 'three'],
            ['three', 'four'],

            ['four', 'one'],
            ['four', 'two'],
            ['four', 'three'],
            ['four', 'four'],
        ], $result);
    }

    /**
     * @test
     */
    public function shouldGetDistinctPairs()
    {
        // when
        $result = DataProviders::distinctPairs('one', 'two', 'three', 'four');

        // then
        $this->assertEquals([
            ['one', 'two'],
            ['one', 'three'],
            ['one', 'four'],

            ['two', 'one'],
            ['two', 'three'],
            ['two', 'four'],

            ['three', 'one'],
            ['three', 'two'],
            ['three', 'four'],

            ['four', 'one'],
            ['four', 'two'],
            ['four', 'three'],
        ], $result);
    }

    /**
     * @test
     */
    public function shouldNotContainDuplicates()
    {
        // then
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unexpected duplicate 'one' when generating pairs");

        // when
        DataProviders::pairs('one', 'two', 'one');
    }

    /**
     * @test
     */
    public function testEmpty()
    {
        // when
        $this->assertEmpty(DataProviders::pairs());
    }
}
