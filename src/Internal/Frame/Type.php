<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

class Type
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        if (\is_string($this->value)) {
            return 'string';
        }
        if (\is_int($this->value)) {
            return 'int';
        }
        if (\is_float($this->value)) {
            return 'float';
        }
        if ($this->value === null) {
            return 'null';
        }
        if (\is_bool($this->value)) {
            return 'bool';
        }
        if (\is_array($this->value)) {
            return 'array';
        }
        if (\is_resource($this->value)) {
            return 'resource';
        }
        return 'object';
    }
}
