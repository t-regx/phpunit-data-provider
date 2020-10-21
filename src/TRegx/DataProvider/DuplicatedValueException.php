<?php
namespace TRegx\DataProvider;

class DuplicatedValueException extends \Exception
{
    public function __construct($value)
    {
        $type = Type::asString($value);
        parent::__construct("Duplicated entry passed to each(): $type");
    }
}
