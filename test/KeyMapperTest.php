<?php

declare(strict_types=1);

namespace TRegx\DataProvider\Test;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\KeyMapper;

/**
 * @covers \TRegx\DataProvider\KeyMapper
 */
class KeyMapperTest extends TestCase
{
    /**
     * @test
     */
    public function test(): void
    {
        // given
        $keyMapper = new KeyMapper(function (array $keys) {
            return join('+', $keys);
        });

        // when
        $result = $keyMapper->map([
            '[1,"welcome",2]' => true,
            '[2,"hello",3]' => false,
        ]);

        // then
        $expected = [
            '1+welcome+2' => true,
            '2+hello+3' => false,
        ];
        $this->assertEquals($expected, iterator_to_array($result));
    }

    /**
     * @test
     */
    public function keyMapperShouldMapRegularKey(): void
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
        $this->assertEquals($expected, iterator_to_array($result));
    }
}
