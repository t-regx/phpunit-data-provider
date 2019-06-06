<?php
namespace TRegx\CrossData;

class KeyMapper
{
    /** @var callable */
    private $mapper;

    public function __construct(callable $mapper)
    {
        $this->mapper = $mapper;
    }

    public function map(array $input): array
    {
        $result = [];
        foreach ($input as $key => $value) {
            $newKey = call_user_func($this->mapper, json_decode($key));
            $result[$newKey] = $value;
        }
        return $result;
    }
}
