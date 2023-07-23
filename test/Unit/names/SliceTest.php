<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class SliceTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldSliceAssociative()
    {
        // given
        $provider = DataProvider::of([
            'ned'     => ['Eddard', 'Stark'],
            'jon'     => ['Jon', 'Snow'],
            'arya'    => ['Arya', 'Stark'],
            'joffrey' => ['Joffrey', 'Baratheon'],
            'brienne' => ['Brienne', 'Tarth'],
            'randyll' => ['Randyll', 'Tarly'],
        ]);
        // when
        $sliced = $provider->slice(2, 3);
        // then
        $this->assertIterates($sliced, [
            'arya'    => ['Arya', 'Stark'],
            'joffrey' => ['Joffrey', 'Baratheon'],
            'brienne' => ['Brienne', 'Tarth'],
        ]);
    }

    /**
     * @test
     */
    public function shouldSliceAssociativeInteger()
    {
        // given
        $provider = DataProvider::of([
            0 => ['Eddard', 'Stark'],
            1 => ['Jon', 'Snow'],
            2 => ['Arya', 'Stark'],
            3 => ['Joffrey', 'Baratheon'],
            5 => ['Brienne', 'Tarth'],
            6 => ['Randyll', 'Tarly'],
        ]);
        // when
        $sliced = $provider->slice(0, 3);
        // then
        $this->assertIteratesNames($sliced, ['[0]', '[1]', '[2]']);
    }

    /**
     * @test
     */
    public function shouldSliceSequential()
    {
        // given
        $provider = DataProvider::of([
            ['Eddard', 'Stark'],
            ['Jon', 'Snow'],
            ['Arya', 'Stark'],
            ['Joffrey', 'Baratheon'],
            ['Brienne', 'Tarth'],
            ['Randyll', 'Tarly'],
        ]);
        // when
        $sliced = $provider->slice(2, 3);
        // then
        $this->assertIteratesNames($sliced, ['#0', '#1', '#2']);
    }

    /**
     * @test
     */
    public function shouldSliceAssociativeMany()
    {
        // given
        $provider = DataProvider::zip(
            ['ned'     => ['Eddard'],
             'jon'     => ['Jon'],
             'arya'    => ['Arya'],
             'joffrey' => ['Joffrey'],
             'brienne' => ['Brienne'],
             'randyll' => ['Randyll']],
            [['Stark'], ['Snow'], ['Stark'], ['Baratheon'], ['Tarth'], ['Tarly']]);
        // when
        $sliced = $provider->slice(2, 3);
        // then
        $this->assertIteratesNames($sliced, ["'arya', #0", "'joffrey', #1", "'brienne', #2"]);
    }

    /**
     * @test
     */
    public function shouldSliceSequentialMany()
    {
        // given
        $provider = DataProvider::zip(
            [['Eddard'], ['Jon'], ['Arya'], ['Joffrey'], ['Brienne'], ['Randyll']],
            [['Stark'], ['Snow'], ['Stark'], ['Baratheon'], ['Tarth'], ['Tarly']]);
        // when
        $sliced = $provider->slice(2, 3);
        // then
        $this->assertIteratesNames($sliced, ["#0, #0", "#1, #1", "#2, #2"]);
    }
}
