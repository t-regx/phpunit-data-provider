<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View\Key;

interface Key
{
    public function toString(bool $segment, bool $includeType);
}
