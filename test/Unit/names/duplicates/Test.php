<?php
namespace Test\Unit\names\duplicates;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldJoinDuplicates()
    {
        // given
        $names = [
            'ned'     => ['Eddard', 'Stark'],
            'stannis' => ['Stannis', 'Baratheon'],
        ];
        // when
        $joined = DataProvider::join($names, $names);
        // then
        $this->assertIteratesNames($joined, [
            "'ned' !0",
            "'stannis' !1",
            "'ned' !2",
            "'stannis' !3",
        ]);
    }

    /**
     * @test
     */
    public function shouldOnlyMarkDuplicates()
    {
        // given
        // when
        $joined = DataProvider::join([
            'ned'     => ['Eddard'],
            'stannis' => ['Stannis'],
            'balon'   => ['Balon'],
        ], [
            'stannis' => ['Stannis'],
        ]);
        // then
        $this->assertIteratesNames($joined, [
            'ned',
            "'stannis' !0",
            'balon',
            "'stannis' !1",
        ]);
    }
}
