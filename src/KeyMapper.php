<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class KeyMapper
{
    /** @var callable */
    private $mapper;

    public function __construct(callable $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param iterable $input
     * @return \Generator<string, mixed>
     */
    public function map(iterable $input): \Generator
    {
        foreach ($input as $key => $value) {
            $mappedKey = call_user_func($this->mapper, $this->mapperArgument($key));
            yield $mappedKey => $value;
        }
    }

    private function mapperArgument($key)
    {
        if (is_string($key)) {
            return json_decode($key);
        }
        if (is_int($key)) {
            return [$key];
        }
        // @codeCoverageIgnoreStart
        throw new \InvalidArgumentException();
        // @codeCoverageIgnoreEnd
    }
}
