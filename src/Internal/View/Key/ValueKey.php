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
        if (\is_float($this->value)) {
            $value = $this->formatFloat($this->value);
            return "[$value]";
        }
        if (\is_bool($this->value)) {
            return $this->value ? 'true' : 'false';
        }
        if ($this->value === null) {
            return 'null';
        }
        if (\is_array($this->value)) {
            return 'array';
        }
        if (\is_string($this->value)) {
            $format = \str_replace(
                ["\t", "\n", "\r", "\f", "\v"],
                ['\t', '\n', '\r', '\f', '\v'],
                $this->value);
            if (\trim($this->value) !== $this->value) {
                return "'$format'";
            }
            if ($segment) {
                return "'$format'";
            }
            return $format;
        }
        if (\is_resource($this->value)) {
            return 'resource';
        }
        if (\is_object($this->value)) {
            return '\\' . \get_class($this->value);
        }
        return \uniqid();
    }

    private function formatFloat(float $value): string
    {
        $notation = \strVal($value);
        if (\strPos($notation, '.') === false) {
            return "$notation.0";
        }
        return $notation;
    }
}
