<?php
namespace Test\TRegx\CrossData;

use PHPUnit\Framework\TestCase;
use TRegx\CrossData\KeyMapper;

class KeyMapperTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        // given
        $keyMapper = new KeyMapper(function (array $keys) {
            return join('+', $keys);
        });

        // when
        $result = $keyMapper->map([
            '[1,"welcome",2]' => true,
            '[2,"hello",3]'   => false,
        ]);

        // then
        $expected = [
            '1+welcome+2' => true,
            '2+hello+3'   => false,
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldKeyMapper_mapRegularKey()
    {
        // given
        $keyMapper = new KeyMapper(function (array $keys) {
            return \json_encode($keys);
        });

        // when
        $result = $keyMapper->map([
            0 => true,
            1 => false,
        ]);

        // then
        $expected = [
            '[0]' => true,
            '[1]' => false,
        ];
        $this->assertEquals($expected, $result);
    }
}
