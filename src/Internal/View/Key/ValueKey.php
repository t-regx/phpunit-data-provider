<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View\Key;

class ValueKey implements Key
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toString(bool $segment): string
    {
        if (is_int($this->value)) {
            return "[$this->value]";
        }
        if (\is_string($this->value)) {
            if ($segment) {
                return "'$this->value'";
            }
            return $this->value;
        }
        return \uniqid();
    }
}
