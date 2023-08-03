<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\Internal\View\Key\Key;

class ViewRow
{
    /** @var Key[] */
    public $keys;
    /** @var mixed[] */
    public $values;
    /** @var bool */
    private $manyKeys;

    public function __construct(array $keys, array $values)
    {
        $this->keys = $keys;
        $this->values = $values;
        $this->manyKeys = \count($this->keys) > 1;
    }

    public function formatKeys(): string
    {
        $keys = [];
        foreach ($this->keys as $key) {
            $keys[] = $key->toString($this->manyKeys);
        }
        return join(', ', $keys);
    }
}
