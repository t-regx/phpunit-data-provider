<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class DistinctPairsTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldPairString()
    {
        $pairs = DataProvider::distinctPairs('mp3', 'wav', 'ogg');
        $this->assertIteratesNames($pairs, [
            "'mp3', 'wav'",
            "'mp3', 'ogg'",
            "'wav', 'mp3'",
            "'wav', 'ogg'",
            "'ogg', 'mp3'",
            "'ogg', 'wav'",
        ]);
    }

    /**
     * @test
     */
    public function shouldPairInteger()
    {
        $pairs = DataProvider::distinctPairs(0, 1, 2);
        $this->assertIteratesNames($pairs, [
            "[0], [1]",
            "[0], [2]",
            "[1], [0]",
            "[1], [2]",
            "[2], [0]",
            "[2], [1]",
        ]);
    }
}
