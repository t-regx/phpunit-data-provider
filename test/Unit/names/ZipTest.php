<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class ZipTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldZipAssociative()
    {
        $zip = DataProvider::zip([
            'ned'     => ['Eddard'],
            'jon'     => ['Jon'],
            'arya'    => ['Arya'],
            'joffrey' => ['Joffrey'],
            'brienne' => ['Brienne'],
            'randyll' => ['Randyll'],
        ], [
            'ice'    => ['Ice'],
            'claw'   => ['Longclaw'],
            'needle' => ['Needle'],
            'wail'   => ["Widow's Wail"],
            'oath'   => ['Oathkeeper'],
            'bane'   => ['Heartsbane'],
        ]);
        $this->assertIteratesNames($zip, [
            "'ned', 'ice'",
            "'jon', 'claw'",
            "'arya', 'needle'",
            "'joffrey', 'wail'",
            "'brienne', 'oath'",
            "'randyll', 'bane'",
        ]);
    }

    /**
     * @test
     */
    public function shouldZipAssociativeInteger()
    {
        $zip = DataProvider::zip([
            4 => ['Eddard'],
            5 => ['Jon'],
            6 => ['Arya'],
            7 => ['Joffrey'],
            8 => ['Brienne'],
            9 => ['Randyll'],
        ], [
            'ice'    => ['Ice'],
            'claw'   => ['Longclaw'],
            'needle' => ['Needle'],
            'wail'   => ["Widow's Wail"],
            'oath'   => ['Oathkeeper'],
            'bane'   => ['Heartsbane'],
        ]);
        $this->assertIteratesNames($zip, [
            "[4], 'ice'",
            "[5], 'claw'",
            "[6], 'needle'",
            "[7], 'wail'",
            "[8], 'oath'",
            "[9], 'bane'",
        ]);
    }

    /**
     * @test
     */
    public function shouldZipAssociativeSequential()
    {
        $zip = DataProvider::zip([
            'ned'     => ['Eddard'],
            'jon'     => ['Jon'],
            'arya'    => ['Arya'],
            'joffrey' => ['Joffrey'],
            'brienne' => ['Brienne'],
            'randyll' => ['Randyll'],
        ], [
            ['Ice'],
            ['Longclaw'],
            ['Needle'],
            ["Widow's Wail"],
            ['Oathkeeper'],
            ['Heartsbane'],
        ]);
        $this->assertIteratesNames($zip, [
            "'ned', #0",
            "'jon', #1",
            "'arya', #2",
            "'joffrey', #3",
            "'brienne', #4",
            "'randyll', #5",
        ]);
    }

    /**
     * @test
     */
    public function shouldZipSequential()
    {
        $provider = DataProvider::zip(
            [['Eddard'], ['Jon'], ['Arya'], ['Joffrey']],
            [['Stark'], ['Snow'], ['Stark'], ['Baratheon']]);
        $this->assertIteratesNames($provider, ['#0, #0', '#1, #1', '#2, #2', '#3, #3']);
    }
}
