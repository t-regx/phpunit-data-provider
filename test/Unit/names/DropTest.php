<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class DropTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldPreserveKeys()
    {
        // given
        $provider = DataProvider::zip(
            [
                'l' => ['Luthor'],
                'r' => ['Rhaegar'],
                'v' => ['Vickon'],
            ],
            [
                'tyrell'    => ['Tyrell',],
                'targaryen' => ['Targaryen'],
                'greyjoy'   => ['Greyjoy'],
            ]
        );
        // when
        $dropped = $provider->drop(1, 0);
        // then
        $this->assertIteratesNames($dropped, [
            "'l', 'tyrell'",
            "'r', 'targaryen'",
            "'v', 'greyjoy'",
        ]);
    }

    /**
     * @test
     */
    public function shouldPreserveKeysNext()
    {
        // given
        $provider = DataProvider::zip(
            [
                'l' => ['Luthor'],
                'r' => ['Rhaegar'],
                'v' => ['Vickon'],
            ],
            [
                'tyrell'    => ['Tyrell',],
                'targaryen' => ['Targaryen'],
                'greyjoy'   => ['Greyjoy'],
            ]
        );
        $dropped = $provider->drop(1, 0);
        // when
        $filtered = $dropped->slice(0, 3);
        // then
        $this->assertIteratesNames($filtered, [
            "'l', 'tyrell'",
            "'r', 'targaryen'",
            "'v', 'greyjoy'",
        ]);
    }
}
