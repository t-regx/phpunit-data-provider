<?php
namespace TRegx\CrossData;

use PHPUnit\Framework\TestCase;

class DataProvidersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCross()
    {
        // when
        $result = DataProviders::crossAll([[1], [2]], [['A'], ['B']]);

        // then
        $expected = [
            '[0,0]' => [1, 'A'],
            '[0,1]' => [1, 'B'],
            '[1,0]' => [2, 'A'],
            '[1,1]' => [2, 'B'],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldKeyMap_regular()
    {
        // when
        $result = DataProviders::configure()
            ->input([[1], [2]])
            ->keyMapper(function (array $keys) {
                return join('+', $keys);
            })
            ->create();

        // then
        $this->assertEquals([[1], [2]], $result);
    }

    /**
     * @test
     */
    public function shouldKeyMapper()
    {
        // when
        $result = DataProviders::configure()
            ->input([[1], [2]], [['A'], ['B']])
            ->keyMapper(function ($keys) {
                return join('+', $keys);
            })
            ->create();

        // then
        $expected = [
            '0+0' => [1, 'A'],
            '0+1' => [1, 'B'],
            '1+0' => [2, 'A'],
            '1+1' => [2, 'B'],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldBuild()
    {
        // when
        $result = DataProviders::builder()
            ->crossing([[1], [2]])
            ->crossing([['A'], ['B']])
            ->keyMapper(function ($keys) {
                return join('+', $keys);
            })
            ->build();

        // then
        $expected = [
            '0+0' => [1, 'A'],
            '0+1' => [1, 'B'],
            '1+0' => [2, 'A'],
            '1+1' => [2, 'B'],
        ];
        $this->assertEquals($expected, $result);
    }
}
