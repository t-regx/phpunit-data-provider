<?php

declare(strict_types=1);

namespace Test\TRegx\DataProvider;

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
    public function shouldCross()
    {
        // when
        $result = DataProviders::cross(
            [['login', '/sing-in'], ['logout', '/sign-out']],
            [['ftp', 21], ['http', 80], ['ssh', 22], ['https', 443]]
        );

        // then
        $expected = [
            '[0,0]' => ['login', '/sing-in', 'ftp', 21],
            '[0,1]' => ['login', '/sing-in', 'http', 80],
            '[0,2]' => ['login', '/sing-in', 'ssh', 22],
            '[0,3]' => ['login', '/sing-in', 'https', 443],

            '[1,0]' => ['logout', '/sign-out', 'ftp', 21],
            '[1,1]' => ['logout', '/sign-out', 'http', 80],
            '[1,2]' => ['logout', '/sign-out', 'ssh', 22],
            '[1,3]' => ['logout', '/sign-out', 'https', 443],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function shouldThrowForAssociativeArray()
    {
        // then
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Arguments composed of an associative array');

        // given
        DataProviders::cross([['A'], ['value' => 'value']]);
    }

    /**
     * @test
     */
    public function shouldThrowForInvalidIteration()
    {
        // then
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Argument list is supposed to be an array, 'string' given");

        // given
        DataProviders::cross([['A'], 'not an array']);
    }

    /**
     * @test
     */
    public function shouldGetEach()
    {
        // when
        $each = DataProviders::each(['One', 'Two', 'Three']);

        // then
        $expected = [
            ['One'],
            ['Two'],
            ['Three'],
        ];
        $this->assertEquals($expected, $each);
    }

    /**
     * @test
     */
    public function shouldGetEachNamed()
    {
        // when
        $each = DataProviders::eachNamed(['One', 'Two', 'Three']);

        // then
        $expected = [
            'One' => ['One'],
            'Two' => ['Two'],
            'Three' => ['Three'],
        ];
        $this->assertEquals($expected, $each);
    }
}
