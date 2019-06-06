<?php
namespace Test\TRegx\CrossData;

use PHPUnit\Framework\TestCase;
use TRegx\CrossData\ArrayMatrix;

class ArrayMatrixTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCrossEmptyArray_empty()
    {
        // when
        $result = (new ArrayMatrix())->cross([[]]);

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
        $result = (new ArrayMatrix())->cross([$array, []]);

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
        $result = (new ArrayMatrix())->cross([[], $array]);

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
        $result = (new ArrayMatrix())->cross([$input]);

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
        $result = (new ArrayMatrix())->cross([$array1, $arrayA]);

        // then
        $expected = [
            '[0,0]' => [1, 'A'], '[0,1]' => [1, 'B'], '[0,2]' => [1, 'C'], '[0,3]' => [1, 'D'], '[0,4]' => [1, 'E'],
            '[1,0]' => [2, 'A'], '[1,1]' => [2, 'B'], '[1,2]' => [2, 'C'], '[1,3]' => [2, 'D'], '[1,4]' => [2, 'E'],
            '[2,0]' => [3, 'A'], '[2,1]' => [3, 'B'], '[2,2]' => [3, 'C'], '[2,3]' => [3, 'D'], '[2,4]' => [3, 'E'],
            '[3,0]' => [4, 'A'], '[3,1]' => [4, 'B'], '[3,2]' => [4, 'C'], '[3,3]' => [4, 'D'], '[3,4]' => [4, 'E'],
            '[4,0]' => [5, 'A'], '[4,1]' => [5, 'B'], '[4,2]' => [5, 'C'], '[4,3]' => [5, 'D'], '[4,4]' => [5, 'E'],
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
        $result = (new ArrayMatrix())->cross([$array1, $arrayA]);

        // then
        $expected = [
            '[0,"a"]' => [1, 'A'],
            '[0,0]'   => [1, 'B'],
            '[0,1]'   => [1, 'C'],
            '[0,2]'   => [1, 'D'],

            '["two","a"]' => [2, 'A'],
            '["two",0]'   => [2, 'B'],
            '["two",1]'   => [2, 'C'],
            '["two",2]'   => [2, 'D'],

            '[1,"a"]' => [3, 'A'],
            '[1,0]'   => [3, 'B'],
            '[1,1]'   => [3, 'C'],
            '[1,2]'   => [3, 'D'],
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
        $result = (new ArrayMatrix())->cross([$array1, $arrayA, $arrayRed]);

        // then
        $expected = [
            // 1
            '[0,0,0]' => [1, 'A', 'red'], '[0,0,1]' => [1, 'A', 'green'], '[0,0,2]' => [1, 'A', 'blue'],  // A
            '[0,1,0]' => [1, 'B', 'red'], '[0,1,1]' => [1, 'B', 'green'], '[0,1,2]' => [1, 'B', 'blue'],  // B
            '[0,2,0]' => [1, 'C', 'red'], '[0,2,1]' => [1, 'C', 'green'], '[0,2,2]' => [1, 'C', 'blue'],  // C

            // 2
            '[1,0,0]' => [2, 'A', 'red'], '[1,0,1]' => [2, 'A', 'green'], '[1,0,2]' => [2, 'A', 'blue'],  // A
            '[1,1,0]' => [2, 'B', 'red'], '[1,1,1]' => [2, 'B', 'green'], '[1,1,2]' => [2, 'B', 'blue'],  // B
            '[1,2,0]' => [2, 'C', 'red'], '[1,2,1]' => [2, 'C', 'green'], '[1,2,2]' => [2, 'C', 'blue'],  // C

            // 3
            '[2,0,0]' => [3, 'A', 'red'], '[2,0,1]' => [3, 'A', 'green'], '[2,0,2]' => [3, 'A', 'blue'],  // A
            '[2,1,0]' => [3, 'B', 'red'], '[2,1,1]' => [3, 'B', 'green'], '[2,1,2]' => [3, 'B', 'blue'],  // B
            '[2,2,0]' => [3, 'C', 'red'], '[2,2,1]' => [3, 'C', 'green'], '[2,2,2]' => [3, 'C', 'blue'],  // C
            //                     red                           green                           blue
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldCross_singleItemArrays_multiple_withNames()
    {
        // given
        $array1 = [[1], 'two' => [2], [3]];
        $arrayA = [['A'], ['B'], ['C']];
        $arrayRed = ['r' => ['red'], ['green'], ['blue']];

        // when
        $result = (new ArrayMatrix())->cross([$array1, $arrayA, $arrayRed]);

        // then
        $expected = [
            // 1
            '[0,0,"r"]'     => [1, 'A', 'red'], '[0,0,0]' => [1, 'A', 'green'], '[0,0,1]' => [1, 'A', 'blue'],  // A
            '[0,1,"r"]'     => [1, 'B', 'red'], '[0,1,0]' => [1, 'B', 'green'], '[0,1,1]' => [1, 'B', 'blue'],  // B
            '[0,2,"r"]'     => [1, 'C', 'red'], '[0,2,0]' => [1, 'C', 'green'], '[0,2,1]' => [1, 'C', 'blue'],  // C

            // 2
            '["two",0,"r"]' => [2, 'A', 'red'], '["two",0,0]' => [2, 'A', 'green'], '["two",0,1]' => [2, 'A', 'blue'],  // A
            '["two",1,"r"]' => [2, 'B', 'red'], '["two",1,0]' => [2, 'B', 'green'], '["two",1,1]' => [2, 'B', 'blue'],  // B
            '["two",2,"r"]' => [2, 'C', 'red'], '["two",2,0]' => [2, 'C', 'green'], '["two",2,1]' => [2, 'C', 'blue'],  // C

            // 3
            '[1,0,"r"]'     => [3, 'A', 'red'], '[1,0,0]' => [3, 'A', 'green'], '[1,0,1]' => [3, 'A', 'blue'],  // A
            '[1,1,"r"]'     => [3, 'B', 'red'], '[1,1,0]' => [3, 'B', 'green'], '[1,1,1]' => [3, 'B', 'blue'],  // B
            '[1,2,"r"]'     => [3, 'C', 'red'], '[1,2,0]' => [3, 'C', 'green'], '[1,2,1]' => [3, 'C', 'blue'],  // C
            //                     red                           green                           blue
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldQuote_firstArray()
    {
        // given
        $array1 = ['[6,7]' => [1], [2]];
        $arrayA = ['[4,5]' => ['A'], ['B']];

        // when
        $result = (new ArrayMatrix())->cross([$array1, $arrayA]);

        // then
        $expected = [
            '["[6,7]","[4,5]"]' => [1, 'A'],
            '["[6,7]",0]'       => [1, 'B'],
            '[0,"[4,5]"]'       => [2, 'A'],
            '[0,0]'             => [2, 'B'],
        ];
        $this->assertEquals($expected, $result);
    }
}
