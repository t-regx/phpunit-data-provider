<?php
namespace Test\Fixture\TestCase;

use PHPUnit\Framework\Assert;

trait TestCasePasses
{
    public function pass()
    {
        Assert::assertTrue(true);
    }
}
