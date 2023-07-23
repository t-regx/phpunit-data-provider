<?php
namespace Test\Unit\entry;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use TRegx\PhpUnit\DataProviders\DataProvider;

class CrossTest extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     */
    public function shouldCross()
    {
        $cross = DataProvider::cross(
            [['Jaime', 'Lannister'], ['Cersei', 'Lannister']],
            [['Eddard', 'Stark'], ['Stannis', 'Baratheon']]
        );
        $this->assertIteratesValues($cross, [
            ['Jaime', 'Lannister', 'Eddard', 'Stark'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon'],
        ]);
    }

    /**
     * @test
     */
    public function shouldCrossIgnoreEmptyFirst()
    {
        $cross = DataProvider::cross(
            [],
            [['Jaime', 'Lannister'], ['Cersei', 'Lannister']],
            [['Eddard', 'Stark'], ['Stannis', 'Baratheon']]
        );
        $this->assertIteratesValues($cross, [
            ['Jaime', 'Lannister', 'Eddard', 'Stark'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon'],
        ]);
    }

    /**
     * @test
     */
    public function shouldCrossIgnoreEmptyMiddle()
    {
        $cross = DataProvider::cross(
            [['Jaime', 'Lannister'], ['Cersei', 'Lannister']],
            [],
            [['Eddard', 'Stark'], ['Stannis', 'Baratheon']]
        );
        $this->assertIteratesValues($cross, [
            ['Jaime', 'Lannister', 'Eddard', 'Stark'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon'],
        ]);
    }

    /**
     * @test
     */
    public function shouldCrossMany()
    {
        $cross = DataProvider::cross(
            [['Jaime', 'Lannister'], ['Cersei', 'Lannister']],
            [['Eddard', 'Stark'], ['Stannis', 'Baratheon']],
            [['Balon', 'Greyjoy'], ['Tyrion', 'Lannister']],
            [['Joffrey', 'Baratheon'], ['Sansa', 'Stark']]
        );
        $this->assertIteratesValues($cross, [
            ['Jaime', 'Lannister', 'Eddard', 'Stark', 'Balon', 'Greyjoy', 'Joffrey', 'Baratheon'],
            ['Jaime', 'Lannister', 'Eddard', 'Stark', 'Balon', 'Greyjoy', 'Sansa', 'Stark'],
            ['Jaime', 'Lannister', 'Eddard', 'Stark', 'Tyrion', 'Lannister', 'Joffrey', 'Baratheon'],
            ['Jaime', 'Lannister', 'Eddard', 'Stark', 'Tyrion', 'Lannister', 'Sansa', 'Stark'],

            ['Jaime', 'Lannister', 'Stannis', 'Baratheon', 'Balon', 'Greyjoy', 'Joffrey', 'Baratheon'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon', 'Balon', 'Greyjoy', 'Sansa', 'Stark'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon', 'Tyrion', 'Lannister', 'Joffrey', 'Baratheon'],
            ['Jaime', 'Lannister', 'Stannis', 'Baratheon', 'Tyrion', 'Lannister', 'Sansa', 'Stark'],

            ['Cersei', 'Lannister', 'Eddard', 'Stark', 'Balon', 'Greyjoy', 'Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark', 'Balon', 'Greyjoy', 'Sansa', 'Stark'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark', 'Tyrion', 'Lannister', 'Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister', 'Eddard', 'Stark', 'Tyrion', 'Lannister', 'Sansa', 'Stark'],

            ['Cersei', 'Lannister', 'Stannis', 'Baratheon', 'Balon', 'Greyjoy', 'Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon', 'Balon', 'Greyjoy', 'Sansa', 'Stark'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon', 'Tyrion', 'Lannister', 'Joffrey', 'Baratheon'],
            ['Cersei', 'Lannister', 'Stannis', 'Baratheon', 'Tyrion', 'Lannister', 'Sansa', 'Stark'],
        ]);
    }

    /**
     * @test
     */
    public function shouldAcceptSingleEmpty()
    {
        $this->assertIterates(DataProvider::cross([]), []);
    }
}
