<?php
namespace Test\Unit\malformed;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Executes;
use Test\Fixture\Facet\ProviderType\ProviderType;
use Test\Fixture\Facet\ProviderType\ProviderTypes;
use Test\Fixture\StandardTypes;
use Test\Fixture\TestCase\TestCaseExactMessage;
use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\MalformedDataProviderException;

class JoinTest extends TestCase
{
    use Executes, ProviderTypes, TestCaseExactMessage, StandardTypes;

    /**
     * @test
     * @dataProvider providerTypes_standardTypes
     */
    public function shouldThrowForMalformedDataProvider(ProviderType $type, $value, string $typeName)
    {
        // given
        $provider = DataProvider::join($type->fromArray([$value]));
        // then
        $this->expectException(MalformedDataProviderException::class);
        $this->expectExceptionMessage("Failed to accept malformed data provider, expected: array[], but got: $typeName");
        // when
        $this->execute($provider);
    }

    public function providerTypes_standardTypes(): DataProvider
    {
        return DataProvider::cross($this->providerTypes(), $this->standardTypes());
    }
}
