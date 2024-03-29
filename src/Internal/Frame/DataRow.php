<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

class DataRow
{
    /** @var mixed[] */
    public $keys;
    /** @var bool[] */
    private $associative;
    /** @var mixed[] */
    public $values;

    public function __construct(array $keys, array $assoc, array $values)
    {
        $this->keys = $keys;
        $this->associative = $assoc;
        $this->values = $values;
    }

    public static function of(array $values): DataRow
    {
        return new DataRow($values, \array_fill(0, \count($values), true), $values);
    }

    public static function dictionaryEntry($key, $value): DataRow
    {
        return new DataRow([$key], [true], [$value]);
    }

    public function isAssociative(int $index): bool
    {
        return $this->associative[$index];
    }

    public function set(array $values): DataRow
    {
        return new DataRow($this->keys, $this->associative, $values);
    }

    public function joined(DataRow $dataRow): DataRow
    {
        return new DataRow(
            \array_merge($this->keys, $dataRow->keys),
            \array_merge($this->associative, $dataRow->associative),
            \array_merge($this->values, $dataRow->values));
    }
}
