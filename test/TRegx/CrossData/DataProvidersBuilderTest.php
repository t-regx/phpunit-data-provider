<?php
namespace TRegx\CrossData;

use PHPUnit\Framework\TestCase;

class DataProvidersBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function test()
    {
        // given
        $builder = new DataProvidersBuilder([], '\json_encode');

        // when
        $result = $builder
            ->crossing([[1], [2]])
            ->crossing([['A'], ['B']])
            ->keyMapper(function (array $keys) {
                return join('+', $keys);
            })
            ->build();

        // then
        $this->assertEquals(['0+0' => [1, 'A'], '0+1' => [1, 'B'], '1+0' => [2, 'A'], '1+1' => [2, 'B']], $result);
    }
}
