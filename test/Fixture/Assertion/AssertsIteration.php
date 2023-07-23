<?php
namespace Test\Fixture\Assertion;

use PHPUnit\Framework\Assert;
use TRegx\PhpUnit\DataProviders\DataProvider;

trait AssertsIteration
{
    public function assertIterates(DataProvider $provider, $expected): void
    {
        Assert::assertSame($expected, \iterator_to_array($provider));
    }

    public function assertIteratesValues(DataProvider $provider, array $expected): void
    {
        Assert::assertSame($expected, \array_values(\iterator_to_array($provider)));
    }

    public function assertIteratesNames(DataProvider $provider, array $expected)
    {
        Assert::assertSame($expected, \array_keys(\iterator_to_array($provider)));
    }
}
