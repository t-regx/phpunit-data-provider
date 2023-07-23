<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class JoinTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldJoinAssociative()
    {
        $join = DataProvider::join([
            'ned' => ['Eddard', 'Ice'],
            'jon' => ['Jon', 'Longclaw'],
        ], [
            'arya'    => ['Arya', 'Needle'],
            'joffrey' => ['Joffrey', "Widow's Wail"],
        ], [
            'brienne' => ['Brienne', 'Oathkeeper'],
            'randyll' => ['Randyll', 'Heartsbane'],
        ]);
        $this->assertIteratesNames($join, [
            'ned',
            'jon',
            'arya',
            'joffrey',
            'brienne',
            'randyll',
        ]);
    }

    /**
     * @test
     */
    public function shouldJoinAssociativeInteger()
    {
        $join = DataProvider::join([
            1 => ['Eddard', 'Ice'],
            2 => ['Jon', 'Longclaw'],
        ], [
            4 => ['Arya', 'Needle'],
            5 => ['Joffrey', "Widow's Wail"],
        ], [
            8 => ['Brienne', 'Oathkeeper'],
            9 => ['Randyll', 'Heartsbane'],
        ]);
        $this->assertIteratesNames($join, [
            '[1]',
            '[2]',
            '[4]',
            '[5]',
            '[8]',
            '[9]',
        ]);
    }

    /**
     * @test
     */
    public function shouldJoinSequential()
    {
        $join = DataProvider::join([['Eddard'], ['Jon']], [['Arya'], ['Joffrey']], [['Brienne'], ['Randyll']]);
        $this->assertIteratesNames($join, ['#0', '#1', '#2', '#3', '#4', '#5']);
    }
}
