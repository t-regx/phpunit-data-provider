<?php

namespace Test\TRegx\DataProvider\pairs;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\DataProviders;

/**
 * @covers \TRegx\DataProvider\DataProviders
 */
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
            'one,one' => ['one', 'one'],
            'one,two' => ['one', 'two'],
            'one,three' => ['one', 'three'],
            'one,four' => ['one', 'four'],

            'two,one' => ['two', 'one'],
            'two,two' => ['two', 'two'],
            'two,three' => ['two', 'three'],
            'two,four' => ['two', 'four'],

            'three,one' => ['three', 'one'],
            'three,two' => ['three', 'two'],
            'three,three' => ['three', 'three'],
            'three,four' => ['three', 'four'],

            'four,one' => ['four', 'one'],
            'four,two' => ['four', 'two'],
            'four,three' => ['four', 'three'],
            'four,four' => ['four', 'four'],
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
            'one,two' => ['one', 'two'],
            'one,three' => ['one', 'three'],
            'one,four' => ['one', 'four'],

            'two,one' => ['two', 'one'],
            'two,three' => ['two', 'three'],
            'two,four' => ['two', 'four'],

            'three,one' => ['three', 'one'],
            'three,two' => ['three', 'two'],
            'three,four' => ['three', 'four'],

            'four,one' => ['four', 'one'],
            'four,two' => ['four', 'two'],
            'four,three' => ['four', 'three'],
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

    /**
     * @test
     */
    public function shouldDisplayKeys_ofVariousTypes()
    {
        // given
        $int = 42;
        $array = ['A', 'B', 'C'];
        $function = function () {
        };
        $object = new DataProviders([[]], $function, $function);

        // when
        $result = DataProviders::pairs($int, $array, $object, $function);

        // then
        $this->assertEquals([
            'integer (42),integer (42)' => [$int, $int],
            'integer (42),array (3)' => [$int, $array],
            'integer (42),TRegx\DataProvider\DataProviders' => [$int, $object],
            'integer (42),Closure' => [$int, $function],

            'array (3),integer (42)' => [$array, $int],
            'array (3),array (3)' => [$array, $array],
            'array (3),TRegx\DataProvider\DataProviders' => [$array, $object],
            'array (3),Closure' => [$array, $function],

            'TRegx\DataProvider\DataProviders,integer (42)' => [$object, $int],
            'TRegx\DataProvider\DataProviders,array (3)' => [$object, $array],
            'TRegx\DataProvider\DataProviders,TRegx\DataProvider\DataProviders' => [$object, $object],
            'TRegx\DataProvider\DataProviders,Closure' => [$object, $function],

            'Closure,integer (42)' => [$function, $int],
            'Closure,array (3)' => [$function, $array],
            'Closure,TRegx\DataProvider\DataProviders' => [$function, $object],
            'Closure,Closure' => [$function, $function],
        ], $result);
    }
}
