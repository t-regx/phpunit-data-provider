<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

class DataRow
{
    /** @var mixed */
    public $key;
    /** @var mixed */
    public $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
