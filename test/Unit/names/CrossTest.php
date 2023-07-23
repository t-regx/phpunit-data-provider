<?php
namespace Test\Unit\names;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class CrossTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldCrossAssociativeString()
    {
        $cross = DataProvider::cross(
            [
                'jaime'  => ['Jaime', 'Lannister'],
                'cersei' => ['Cersei', 'Lannister']
            ],
            [
                'ned'     => ['Eddard', 'Stark'],
                'stannis' => ['Stannis', 'Baratheon']
            ]
        );
        $this->assertIteratesNames($cross, [
            "'jaime', 'ned'",
            "'jaime', 'stannis'",
            "'cersei', 'ned'",
            "'cersei', 'stannis'",
        ]);
    }

    /**
     * @test
     */
    public function shouldCrossAssociativeInteger()
    {
        $cross = DataProvider::cross(
            [['Jaime', 'Lannister'], ['Cersei', 'Lannister']],
            [['Eddard', 'Stark'], ['Stannis', 'Baratheon']],
            [['Balon', 'Greyjoy'], ['Tyrion', 'Lannister']]
        );
        $this->assertIteratesNames($cross, [
            '[0], [0], [0]',
            '[0], [0], [1]',
            '[0], [1], [0]',
            '[0], [1], [1]',
            '[1], [0], [0]',
            '[1], [0], [1]',
            '[1], [1], [0]',
            '[1], [1], [1]',
        ]);
    }
}
