<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

abstract class DataFrame
{
    /**
     * @return DataRow[]
     */
    public abstract function dataset(): array;
}
