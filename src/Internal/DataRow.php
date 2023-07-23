<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

class DataRow
{
    /** @var mixed */
    public $key;
    /** @var bool */
    private $associative;
    /** @var mixed[] */
    public $values;

    public function __construct($key, bool $associative, array $values)
    {
        $this->key = $key;
        $this->associative = $associative;
        $this->values = $values;
    }

    public static function associative($key, array $values): DataRow
    {
        return new DataRow($key, true, $values);
    }

    public function isAssociative(): bool
    {
        return $this->associative;
    }
}
