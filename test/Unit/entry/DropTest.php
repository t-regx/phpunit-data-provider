<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class DropTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldDrop()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(1);
        // then
        $this->assertIteratesValues($dropped, [
            ['Luthor', 'Growing Strong'],
            ['Rhaegar', 'Fire and Blood'],
            ['Vickon', 'We Do Not Sow'],
        ]);
    }

    /**
     * @test
     */
    public function shouldDropMultiple()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(2, 0);
        // then
        $this->assertIteratesValues($dropped, [
            ['Tyrell'],
            ['Targaryen'],
            ['Greyjoy'],
        ]);
    }

    /**
     * @test
     */
    public function shouldDropTwice()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(0)->drop(0);
        // then
        $this->assertIteratesValues($dropped, [
            ['Growing Strong'],
            ['Fire and Blood'],
            ['We Do Not Sow'],
        ]);
    }

    /**
     * @test
     */
    public function shouldDropRepeatedKey()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(1, 1, 1);
        // then
        $this->assertIteratesValues($dropped, [
            ['Luthor', 'Growing Strong'],
            ['Rhaegar', 'Fire and Blood'],
            ['Vickon', 'We Do Not Sow'],
        ]);
    }

    /**
     * @test
     */
    public function shouldDropNegativeIndexLast()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(-1);
        // then
        $this->assertIteratesValues($dropped, [
            ['Luthor', 'Tyrell'],
            ['Rhaegar', 'Targaryen'],
            ['Vickon', 'Greyjoy'],
        ]);
    }

    /**
     * @test
     */
    public function shouldDropNegativeIndex()
    {
        // given
        $provider = DataProvider::of([
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ]);
        // when
        $dropped = $provider->drop(-2);
        // then
        $this->assertIteratesValues($dropped, [
            ['Luthor', 'Growing Strong'],
            ['Rhaegar', 'Fire and Blood'],
            ['Vickon', 'We Do Not Sow'],
        ]);
    }

    /**
     * @test
     * @dataProvider overflownIndices
     */
    public function shouldIgnoreOverflownIndex(int $overflownIndex)
    {
        // given
        $input = [
            ['Luthor', 'Tyrell', 'Growing Strong'],
            ['Rhaegar', 'Targaryen', 'Fire and Blood'],
            ['Vickon', 'Greyjoy', 'We Do Not Sow'],
        ];
        $provider = DataProvider::of($input);
        // when
        $dropped = $provider->drop($overflownIndex);
        // then
        $this->assertIteratesValues($dropped, $input);
    }

    public function overflownIndices(): DataProvider
    {
        return DataProvider::list(4, 5, 7, 8, -4, -5, -7, -8);
    }
}
