<?php
namespace Test\Unit\iterable;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\Facet\ProviderType\ProviderType;
use Test\Fixture\Facet\ProviderType\ProviderTypes;
use TRegx\PhpUnit\DataProviders\DataProvider;

class OfTest extends TestCase
{
    use AssertsIteration, ProviderTypes;

    /**
     * @test
     * @dataProvider providerTypes
     */
    public function shouldAcceptIterable(ProviderType $type)
    {
        $provider = DataProvider::of($type->fromArray([
            'ned'      => ['Eddard', 'Stark'],
            'mad king' => ['Aerys II', 'Targaryen'],
        ]));
        $this->assertIterates($provider, [
            'ned'      => ['Eddard', 'Stark'],
            'mad king' => ['Aerys II', 'Targaryen'],
        ]);
    }
}
