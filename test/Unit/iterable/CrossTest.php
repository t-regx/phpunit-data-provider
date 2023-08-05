<?php
namespace Test\Unit\iterable;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Facet\ProviderType\ProviderType;
use Test\Fixture\Facet\ProviderType\ProviderTypes;
use TRegx\PhpUnit\DataProviders\DataProvider;

class CrossTest extends TestCase
{
    use AssertsIteration, ProviderTypes;

    /**
     * @test
     * @dataProvider providerTypes
     */
    public function shouldAcceptIterable(ProviderType $type)
    {
        $provider = DataProvider::cross(
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
            "'ned', 'reaper'"       => ['Eddard', 'Stark', 'Balon', 'Greyjoy'],
            "'ned', 'brother'"      => ['Eddard', 'Stark', 'Stannis', 'Baratheon'],
            "'mad king', 'reaper'"  => ['Aerys II', 'Targaryen', 'Balon', 'Greyjoy'],
            "'mad king', 'brother'" => ['Aerys II', 'Targaryen', 'Stannis', 'Baratheon'],
        ]);
    }

    /**
     * @test
     * @dataProvider providerTypes
     */
    public function shouldAcceptIterableEmpty(ProviderType $type)
    {
        $provider = DataProvider::cross(
            $type->fromArray([
                'ned'      => ['Eddard', 'Stark'],
                'mad king' => ['Aerys II', 'Targaryen'],
            ]),
            $type->fromArray([]),
            $type->fromArray([
                'reaper'  => ['Balon', 'Greyjoy'],
                'brother' => ['Stannis', 'Baratheon'],
            ])
        );
        $this->assertIterates($provider, [
            "'ned', 'reaper'"       => ['Eddard', 'Stark', 'Balon', 'Greyjoy'],
            "'ned', 'brother'"      => ['Eddard', 'Stark', 'Stannis', 'Baratheon'],
            "'mad king', 'reaper'"  => ['Aerys II', 'Targaryen', 'Balon', 'Greyjoy'],
            "'mad king', 'brother'" => ['Aerys II', 'Targaryen', 'Stannis', 'Baratheon'],
        ]);
    }
}
