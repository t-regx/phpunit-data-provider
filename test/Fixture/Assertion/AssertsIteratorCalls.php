<?php
namespace Test\Fixture\Assertion;

use PHPUnit\Framework\Assert;
use Test\Fixture\HistoryIterator;

trait AssertsIteratorCalls
{
    public function assertSingleIteration(HistoryIterator $iterator, int $elements): void
    {
        Assert::assertSame(\iterator_to_array($this->expectedMethods($elements)), $iterator->history);
    }

    private function expectedMethods(int $iterations): \Generator
    {
        yield 'rewind';
        foreach (\range(1, $iterations) as $ignored) {
            yield "valid";
            yield "current";
            yield "key";
            yield "next";
        }
        yield 'valid';
    }
}
