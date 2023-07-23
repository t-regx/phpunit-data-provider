<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class JoinTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldJoinIdentity()
    {
        $join = DataProvider::join([
            ['Eddard', 'Ice'],
            ['Jon', 'Longclaw'],
        ]);
        $this->assertIteratesValues($join, [
            ['Eddard', 'Ice'],
            ['Jon', 'Longclaw'],
        ]);
    }

    /**
     * @test
     */
    public function shouldJoinMany()
    {
        $first = [
            'ned' => ['Eddard', 'Ice'],
            'jon' => ['Jon', 'Longclaw'],
        ];
        $second = [
            'arya'    => ['Arya', 'Needle'],
            'joffrey' => ['Joffrey', "Widow's Wail"],
        ];
        $third = [
            'brienne' => ['Brienne', 'Oathkeeper'],
            'randyll' => ['Randyll', 'Heartsbane'],
        ];
        $join = DataProvider::join($first, $second, $third);
        $this->assertIteratesValues($join, [
            ['Eddard', 'Ice'],
            ['Jon', 'Longclaw'],
            ['Arya', 'Needle'],
            ['Joffrey', "Widow's Wail"],
            ['Brienne', 'Oathkeeper'],
            ['Randyll', 'Heartsbane'],
        ]);
    }
}
