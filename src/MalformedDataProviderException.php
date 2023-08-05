<?php
namespace TRegx\PhpUnit\DataProviders;

use TRegx\PhpUnit\DataProviders\Internal\Type;

class MalformedDataProviderException extends \RuntimeException
{
    public function __construct(Type $type)
    {
        parent::__construct("Failed to accept malformed data provider, expected: array[], but got: $type");
    }
}
