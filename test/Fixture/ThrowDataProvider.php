<?php
namespace Test\Fixture;

use TRegx\PhpUnit\DataProviders\DataProvider;

class ThrowDataProvider extends DataProvider
{
    protected function dataset(): array
    {
        throw new \AssertionError("Failed to assert that iterable was not used");
    }
}
