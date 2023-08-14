<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\Internal\Type;
use UnexpectedValueException;

class FlatMapper
{
    /** @var callable */
    private $mapper;

    public function __construct(callable $mapper)
    {
        $this->mapper = $mapper;
    }

    public function apply(array $arguments): array
    {
        $rows = ($this->mapper)(...$arguments);
        if (!\is_array($rows)) {
            throw new UnexpectedValueException('Failed to flat map data rows. Expected array of rows, given: ' . new Type($rows));
        }
        $result = [];
        foreach ($rows as $key => $row) {
            if (!\is_array($row)) {
                throw new UnexpectedValueException('Failed to flat map data rows. Expected array of arguments, given: ' . new Type($row));
            }
            $result[$key] = \array_values($row);
        }
        return $result;
    }
}
