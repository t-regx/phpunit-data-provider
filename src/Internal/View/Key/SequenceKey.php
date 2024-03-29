<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View\Key;

class SequenceKey implements Key
{
    /** @var int */
    public $index;

    public function __construct(int $index)
    {
        $this->index = $index;
    }

    public function toString(bool $segment, bool $includeType): string
    {
        return "#$this->index";
    }
}
