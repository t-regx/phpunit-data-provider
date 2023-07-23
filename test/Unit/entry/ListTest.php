<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class ListTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldIterate()
    {
        $list = DataProvider::list('Joffrey', 'Cersei', 'Ilyn Payne', 'The Hound');
        $this->assertIterates($list, [
            'Joffrey'    => ['Joffrey'],
            'Cersei'     => ['Cersei'],
            'Ilyn Payne' => ['Ilyn Payne'],
            'The Hound'  => ['The Hound'],
        ]);
    }
}
