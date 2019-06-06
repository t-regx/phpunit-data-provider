<?php
namespace Test\TRegx\CrossData;

use PHPUnit\Framework\TestCase;
use TRegx\CrossData\CrossDataProviders;

class CrossDataProvidersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCrossEmptyArray_first()
    {
        // given
        $array = ['A', 'B', 'C', 'D', 'E'];

        // when
        $result = CrossDataProviders::builder()->create([], $array);

        // then
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function shouldCrossEmptyArray_second()
    {
        // given
        $array = ['A', 'B', 'C', 'D', 'E'];

        // when
        $result = CrossDataProviders::builder()->create($array, []);

        // then
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function shouldCross_singleItemArrays()
    {
        // given
        $array1 = [1, 2, 3, 4, 5];
        $arrayA = ['A', 'B', 'C', 'D', 'E'];

        // when
        $result = CrossDataProviders::builder()->create($array1, $arrayA);

        // then
        $expected = [
            [1, 'A'], [1, 'B'], [1, 'C'], [1, 'D'], [1, 'E'],
            [2, 'A'], [2, 'B'], [2, 'C'], [2, 'D'], [2, 'E'],
            [3, 'A'], [3, 'B'], [3, 'C'], [3, 'D'], [3, 'E'],
            [4, 'A'], [4, 'B'], [4, 'C'], [4, 'D'], [4, 'E'],
            [5, 'A'], [5, 'B'], [5, 'C'], [5, 'D'], [5, 'E'],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldCross_singleItemArrays_withNames()
    {
        // given
        $array1 = [1, 'two' => 2, 3];
        $arrayA = ['a' => 'A', 'B', 'C', 'D'];

        // when
        $result = CrossDataProviders::builder()->create($array1, $arrayA);

        // then
        $expected = [
            '#0 / a' => [1, 'A'], [1, 'B'], [1, 'C'], [1, 'D'],

            'two / a'  => [2, 'A'],
            'two / #0' => [2, 'B'],
            'two / #1' => [2, 'C'],
            'two / #2' => [2, 'D'],

            '#1 / a' => [3, 'A'], [3, 'B'], [3, 'C'], [3, 'D'],
        ];
        $this->assertEquals($expected, $result);
    }
}
