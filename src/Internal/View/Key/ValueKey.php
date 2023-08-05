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

    public function toString(bool $segment, bool $includeType): string
    {
        if (is_int($this->value)) {
            if ($includeType) {
                return "(int) [$this->value]";
            }
            return "[$this->value]";
        }
        if (\is_float($this->value)) {
            $value = $this->formatFloat($this->value);
            if ($includeType) {
                return "(float) [$value]";
            }
            return "[$value]";
        }
        if (\is_bool($this->value)) {
            $value = $this->value ? 'true' : 'false';
            if ($includeType) {
                return '(bool) ' . $value;
            }
            return $value;
        }
        if ($this->value === null) {
            if ($includeType) {
                return '(null)';
            }
            return 'null';
        }
        if (\is_array($this->value)) {
            if ($includeType) {
                return '(array)';
            }
            return 'array';
        }
        if (\is_string($this->value)) {
            $format = \str_replace(
                ["\t", "\n", "\r", "\f", "\v"],
                ['\t', '\n', '\r', '\f', '\v'],
                $this->value);
            if ($includeType) {
                return "(string) '$format'";
            }
            if (\is_int(\key([$this->value => true]))) {
                return "'$format'";
            }
            if (\trim($this->value) !== $this->value || $segment) {
                return "'$format'";
            }
            return $format;
        }
        if (\is_resource($this->value)) {
            if ($includeType) {
                return '(resource)';
            }
            return 'resource';
        }
        $class = '\\' . \get_class($this->value);
        if ($includeType) {
            return "(object) $class";
        }
        return $class;
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
