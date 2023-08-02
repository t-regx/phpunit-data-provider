<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View\Duplicates;

class Set
{
    /** @var string[] */
    private $set = [];

    public function add(string $value): void
    {
        $this->set[$value] = ($this->set[$value] ?? 0) + 1;
    }

    public function isDuplicate(string $value): bool
    {
        return ($this->set[$value] ?? 0) > 1;
    }
}
