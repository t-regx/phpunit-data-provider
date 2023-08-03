<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\Internal\View\Key\Key;

class ViewRow
{
    /** @var Key */
    public $key;
    /** @var mixed[] */
    public $values;

    public function __construct(Key $key, array $values)
    {
        $this->key = $key;
        $this->values = $values;
    }

    public function format(): string
    {
        return $this->key->toString();
    }
}
