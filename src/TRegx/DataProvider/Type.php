<?php
namespace TRegx\DataProvider;

use function count;
use function get_class;
use function gettype;
use function is_array;
use function is_resource;
use function is_scalar;

class Type
{
    public static function asString($value): string
    {
        if ($value === null) {
            return 'null';
        }
        if (is_string($value)) {
            return $value;
        }
        if (is_scalar($value)) {
            return \var_export($value, true);
        }
        if (is_array($value)) {
            $count = count($value);
            return "array ($count)";
        }
        if (is_resource($value)) {
            return 'resource';
        }
        return get_class($value);
    }
}
