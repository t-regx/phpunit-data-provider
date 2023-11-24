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
            return $this->integerValue($includeType);
        }
        if (\is_float($this->value)) {
            return $this->floatValue($includeType);
        }
        if (\is_bool($this->value)) {
            return $this->booleanValue($includeType);
        }
        if ($this->value === null) {
            return $this->valueOfType('null', $includeType);
        }
        if (\is_array($this->value)) {
            return $this->valueOfType('array', $includeType);
        }
        if (\is_string($this->value)) {
            return $this->stringValue($includeType, $segment);
        }
        if (\is_resource($this->value)) {
            return $this->valueOfType('resource', $includeType);
        }
        return $this->classValue($includeType);
    }

    private function formatFloat(float $value): string
    {
        $notation = \strVal($value);
        if (\strPos($notation, '.') === false) {
            return "$notation.0";
        }
        return $notation;
    }

    private function integerValue(bool $includeType): string
    {
        if ($includeType) {
            return "(int) [$this->value]";
        }
        return "[$this->value]";
    }

    private function floatValue(bool $includeType): string
    {
        $value = $this->formatFloat($this->value);
        if ($includeType) {
            return "(float) [$value]";
        }
        return "[$value]";
    }

    private function booleanValue(bool $includeType): string
    {
        $value = $this->value ? 'true' : 'false';
        if ($includeType) {
            return '(bool) ' . $value;
        }
        return $value;
    }

    private function stringValue(bool $includeType, bool $segment): string
    {
        $value = $this->valueWithAsciiEntities();
        if ($includeType) {
            return "(string) '$value'";
        }
        if ($this->similarToSequentialKey() || $this->hasWhitespace() || $segment) {
            return "'$value'";
        }
        return $value;
    }

    private function valueWithAsciiEntities(): string
    {
        return \str_replace(
            ["\t", "\n", "\r", "\f", "\v"],
            ['\t', '\n', '\r', '\f', '\v'],
            $this->value);
    }

    private function similarToSequentialKey(): bool
    {
        return \is_int(\key([$this->value => true]));
    }

    private function hasWhitespace(): bool
    {
        return \trim($this->value) !== $this->value;
    }

    private function classValue(bool $includeType): string
    {
        $class = '\\' . \get_class($this->value);
        if ($includeType) {
            return "(object) $class";
        }
        return $class;
    }

    private function valueOfType(string $type, bool $includeType): string
    {
        return $includeType ? "($type)" : $type;
    }
}
