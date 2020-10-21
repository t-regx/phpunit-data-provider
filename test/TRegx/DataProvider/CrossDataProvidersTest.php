<?php
namespace Test\TRegx\DataProvider;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\CrossDataProviders;

class CrossDataProvidersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCross()
    {
        // when
        $result = CrossDataProviders::cross([[1], [2]], [['A'], ['B']]);

        // then
        $expected = [
            '[0,0]' => [1, 'A'],
            '[0,1]' => [1, 'B'],
            '[1,0]' => [2, 'A'],
            '[1,1]' => [2, 'B'],
        ];
        $this->assertEquals($expected, $result);
    }
}
