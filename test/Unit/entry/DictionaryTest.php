<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class DictionaryTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        $dictionary = DataProvider::dictionary([
            'Stark'     => 'Eddard',
            'Baratheon' => 'Robert',
            'Balon'     => 'Greyjoy',
            'Rhaegar'   => 'Targaryen'
        ]);
        $this->assertIterates($dictionary, [
            'Stark'     => ['Eddard'],
            'Baratheon' => ['Robert'],
            'Balon'     => ['Greyjoy'],
            'Rhaegar'   => ['Targaryen'],
        ]);
    }
}
