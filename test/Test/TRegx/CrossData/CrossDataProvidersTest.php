<?php
namespace Test\TRegx\CrossData;

use PHPUnit\Framework\TestCase;
use TRegx\CrossData\CrossDataProviders;

class CrossDataProvidersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCrossEmptyArray_empty()
    {
        // when
        $result = CrossDataProviders::builder()->cross([]);

        // then
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function shouldCrossEmptyArray_second()
    {
        // given
        $array = [['A'], ['B'], ['C'], ['D'], ['E']];

        // when
        $result = CrossDataProviders::builder()->cross($array, []);

        // then
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function shouldCrossEmptyArray_first()
    {
        // given
        $array = [['A'], ['B'], ['C'], ['D'], ['E']];

        // when
        $result = CrossDataProviders::builder()->cross([], $array);

        // then
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    public function shouldCross_singleArray_unchanged()
    {
        // given
        $input = [[1], [2], [3], [4], [5]];

        // when
        $result = CrossDataProviders::builder()->cross($input);

        // then
        $this->assertEquals($input, $result);
    }

    /**
     * @test
     */
    public function shouldCross_singleItemArrays()
    {
        // given
        $array1 = [[1], [2], [3], [4], [5]];
        $arrayA = [['A'], ['B'], ['C'], ['D'], ['E']];

        // when
        $result = CrossDataProviders::builder()->cross($array1, $arrayA);

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
        $array1 = [[1], 'two' => [2], [3]];
        $arrayA = ['a' => ['A'], ['B'], ['C'], ['D']];

        // when
        $result = CrossDataProviders::builder()->cross($array1, $arrayA);

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

    /**
     * @test
     */
    public function shouldCross_singleItemArrays_multiple()
    {
        // given
        $array1 = [[1], [2], [3]];
        $arrayA = [['A'], ['B'], ['C']];
        $arrayRed = [['red'], ['green'], ['blue']];

        // when
        $result = CrossDataProviders::builder()->cross($array1, $arrayA, $arrayRed);

        // then
        $expected = [
            // 1
            [1, 'A', 'red'], [1, 'A', 'green'], [1, 'A', 'blue'],  // A
            [1, 'B', 'red'], [1, 'B', 'green'], [1, 'B', 'blue'],  // B
            [1, 'C', 'red'], [1, 'C', 'green'], [1, 'C', 'blue'],  // C

            // 2
            [2, 'A', 'red'], [2, 'A', 'green'], [2, 'A', 'blue'],  // A
            [2, 'B', 'red'], [2, 'B', 'green'], [2, 'B', 'blue'],  // B
            [2, 'C', 'red'], [2, 'C', 'green'], [2, 'C', 'blue'],  // C

            // 3
            [3, 'A', 'red'], [3, 'A', 'green'], [3, 'A', 'blue'],  // A
            [3, 'B', 'red'], [3, 'B', 'green'], [3, 'B', 'blue'],  // B
            [3, 'C', 'red'], [3, 'C', 'green'], [3, 'C', 'blue'],  // C
            //        red              green              blue

        ];
        $this->assertEquals($expected, $result);
    }
}
