<?php
namespace Test\Unit\malformed;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Executes;
use Test\Fixture\Facet\ProviderType\ProviderType;
use Test\Fixture\Facet\ProviderType\ProviderTypes;
use Test\Fixture\TestCase\TestCaseExactMessage;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\MalformedDataProviderException;

class JoinTest extends TestCase
{
    use Executes, ProviderTypes, TestCaseExactMessage;

    /**
     * @test
     * @dataProvider providerTypes_invalidTypes
     */
    public function shouldThrowForMalformedDataProvider(ProviderType $type, $value)
    {
        // given
        $provider = DataProvider::join($type->fromArray([$value]));
        // then
        $this->expectException(MalformedDataProviderException::class);
        $this->expectExceptionMessage('Failed to accept malformed data provider, expected array[]');
        // when
        $this->execute($provider);
    }

    public function providerTypes_invalidTypes(): DataProvider
    {
        return DataProvider::cross($this->providerTypes(), $this->invalidTypes());
    }

    private function invalidTypes(): DataProvider
    {
        return DataProvider::list(4, 4.0, null, 'string', new \stdClass(), function () {
        });
    }
}
