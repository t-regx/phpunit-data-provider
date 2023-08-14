<?php
namespace Test\Fixture;

class Functions
{
    public static function constant($value): callable
    {
        return function () use ($value) {
            return $value;
        };
    }

    public static function toArray(): callable
    {
        return function ($argument): array {
            return [$argument];
        };
    }

    public static function toNestedArray(): callable
    {
        return function ($argument): array {
            return [[$argument]];
        };
    }
}
