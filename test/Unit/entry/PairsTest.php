<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class PairsTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldPair()
    {
        $pairs = DataProvider::pairs('mp3', 'wav', 'ogg');
        $this->assertIteratesValues($pairs, [
            ['mp3', 'mp3'],
            ['mp3', 'wav'],
            ['mp3', 'ogg'],
            ['wav', 'mp3'],
            ['wav', 'wav'],
            ['wav', 'ogg'],
            ['ogg', 'mp3'],
            ['ogg', 'wav'],
            ['ogg', 'ogg'],
        ]);
    }
}
