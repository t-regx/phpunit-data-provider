<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

use TRegx\PhpUnit\DataProviders\Internal\View\Key\ValueKey;

class Type
{
    /** @var mixed */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (new ValueKey($this->value))->toString(false, true);
    }
}
