<?php
namespace Test\Unit\iterable;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Facet\ProviderType\ProviderType;
use Test\Fixture\Facet\ProviderType\ProviderTypes;
use TRegx\PhpUnit\DataProviders\DataProvider;

class JoinTest extends TestCase
{
    use AssertsIteration, ProviderTypes;

    /**
     * @test
     * @dataProvider providerTypes
     */
    public function shouldAcceptIterable(ProviderType $type)
    {
        $provider = DataProvider::join(
            $type->fromArray([
                'ned'      => ['Eddard', 'Stark'],
                'mad king' => ['Aerys II', 'Targaryen'],
            ]),
            $type->fromArray([
                'reaper'  => ['Balon', 'Greyjoy'],
                'brother' => ['Stannis', 'Baratheon'],
            ])
        );
        $this->assertIterates($provider, [
            'ned'      => ['Eddard', 'Stark'],
            'mad king' => ['Aerys II', 'Targaryen'],
            'reaper'   => ['Balon', 'Greyjoy'],
            'brother'  => ['Stannis', 'Baratheon'],
        ]);
    }
}
