<?php
namespace Test\Unit\entry;

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
    public function shouldSliceInitialEmpty()
    {
        $this->assertIterates(DataProvider::of([])->slice(0, 2), []);
    }

    /**
     * @test
     */
    public function shouldSliceEmpty()
    {
        $this->assertIterates(DataProvider::of([['Dracarys']])->slice(1, 0), []);
    }

    /**
     * @test
     */
    public function shouldSliceNegativeStartPositiveLength()
    {
        // given
        $provider = DataProvider::list('Eddard', 'Jon', 'Arya', 'Joffrey', 'Brienne', 'Randyll');
        // when, then
        $this->assertIteratesValues(
            $provider->slice(-4, 2),
            [['Arya'], ['Joffrey']]);
    }

    /**
     * @test
     */
    public function shouldSliceNegativeStartNegativeLength()
    {
        // given
        $provider = DataProvider::list('Eddard', 'Jon', 'Arya', 'Joffrey', 'Brienne', 'Randyll');
        // when, then
        $this->assertIteratesValues(
            $provider->slice(-5, -1),
            [['Jon'], ['Arya'], ['Joffrey'], ['Brienne']]);
    }

    /**
     * @test
     */
    public function shouldSliceNegativeStartAfterNegativeLength()
    {
        // given
        $provider = DataProvider::list('Eddard', 'Jon', 'Arya', 'Joffrey', 'Brienne', 'Randyll');
        // when, then
        $this->assertIteratesValues($provider->slice(-2, -2), []);
        $this->assertIteratesValues($provider->slice(-2, -3), []);
    }

    /**
     * @test
     */
    public function shouldSliceOptionalLength()
    {
        // given
        $provider = DataProvider::list('Eddard', 'Jon', 'Arya', 'Joffrey', 'Brienne', 'Randyll');
        // when, then
        $this->assertIteratesValues($provider->slice(-3), [['Joffrey'], ['Brienne'], ['Randyll']]);
    }
}
