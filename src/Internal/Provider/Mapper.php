<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\Internal\Type;
use UnexpectedValueException;

class Mapper
{
    /** @var callable */
    private $mapper;

    public function __construct(callable $mapper)
    {
        $this->mapper = $mapper;
    }

    public function apply(array $arguments): array
    {
        $mapped = ($this->mapper)(...$arguments);
        if (\is_array($mapped)) {
            return \array_values($mapped);
        }
        throw new UnexpectedValueException('Failed to map data row. Expected array of arguments, given: ' . new Type($mapped));
    }
}
