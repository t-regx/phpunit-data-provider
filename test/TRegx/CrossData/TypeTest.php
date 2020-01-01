<?php
namespace Test\TRegx\CrossData;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\Type;

class TypeTest extends TestCase
{
    /**
     * @test
     * @dataProvider typesMap
     * @param mixed $value
     * @param string $expectedString
     */
    public function shouldGetMessageWithType($value, string $expectedString)
    {
        // when
        $string = Type::asString($value);

        // then
        $this->assertEquals($expectedString, $string);
    }

    function typesMap(): array
    {
        return [
            'null'     => [null, 'null'],
            'true'     => [true, 'true'],
            'false'    => [false, 'false'],
            'int'      => [2, '2'],
            'float'    => [2.23, '2.23'],
            'string'   => ["She's sexy", "She's sexy"],
            'array'    => [[1, new \stdClass(), 3], 'array (3)'],
            'resource' => [self::getResource(), 'resource'],
            'stdClass' => [new \stdClass(), 'stdClass'],
            'class'    => [new \stdClass(), 'stdClass'],
            'function' => [function () {
            }, 'Closure']
        ];
    }

    private static function getResource()
    {
        $resources = get_resources();
        return reset($resources);
    }
}
