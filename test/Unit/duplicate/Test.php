<?php
namespace Test\Unit\duplicate;

use PHPUnit\Framework\TestCase;
use Test\Fixture\Assertion\AssertsIteration;
use Test\Fixture\EntryIterator;
use Test\Fixture\IdentityAggregate;
use TRegx\PhpUnit\DataProviders\DataProvider;

class Test extends TestCase
{
    use AssertsIteration;

    /**
     * @test
     * @dataProvider iterables
     */
    public function shouldAcceptIterableWithDuplicateKeys(iterable $iterable)
    {
        $dataProvider = DataProvider::of($iterable);
        $this->assertIterates($dataProvider, [
            "'one' !0" => ['first'],
            "'one' !1" => ['second'],
        ]);
    }

    public function iterables(): DataProvider
    {
        $entryIterator = new EntryIterator([
            ['one', ['first']],
            ['one', ['second']],
        ]);
        return DataProvider::dictionary([
            \Iterator::class          => $entryIterator,
            \IteratorAggregate::class => new IdentityAggregate($entryIterator),
            \Generator::class         => $this->generatorWithDuplicatedKeys()
        ]);
    }

    private function generatorWithDuplicatedKeys(): \Generator
    {
        yield 'one' => ['first'];
        yield 'one' => ['second'];
    }
}
