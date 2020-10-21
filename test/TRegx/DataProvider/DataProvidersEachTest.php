<?php
namespace Test\TRegx\DataProvider;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\DataProvidersEach;
use TRegx\DataProvider\DuplicatedValueException;

class DataProvidersEachTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowForInvalidType()
    {
        // then
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("eachNamed() only accepts string, but integer (1) given");

        // when
        DataProvidersEach::eachNamed(['One', 'Two', 1]);
    }

    /**
     * @test
     */
    public function shouldThrowForDuplicated_each()
    {
        // then
        $this->expectException(DuplicatedValueException::class);
        $this->expectExceptionMessage("Duplicated entry passed to each(): string ('One')");

        // when
        DataProvidersEach::each(['One', 'Two', 'One']);
    }

    /**
     * @test
     */
    public function shouldThrowForDuplicated_eachNamed()
    {
        // then
        $this->expectException(DuplicatedValueException::class);
        $this->expectExceptionMessage("Duplicated entry passed to each(): string ('One')");

        // when
        DataProvidersEach::eachNamed(['One', 'Two', 'One']);
    }
}
