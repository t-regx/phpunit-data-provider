<?php
namespace TRegx\PhpUnit\DataProviders;

class MalformedDataProviderException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Failed to accept malformed data provider, expected array[]');
    }
}
