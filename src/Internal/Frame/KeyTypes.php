<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

class KeyTypes
{
    /** @var array */
    private $types;

    public function __construct(DataFrame $frame)
    {
        $this->types = $this->types($frame);
    }

    private function types(DataFrame $frame): array
    {
        $types = [];
        foreach ($frame->dataset() as $dataRow) {
            foreach ($dataRow->keys as $index => $key) {
                if ($dataRow->isAssociative($index)) {
                    $valueType = new ValueType($key);
                    $types[$valueType->type()] = true;
                }
            }
        }
        return \array_keys($types);
    }

    public function uniformTypes(): bool
    {
        if ($this->arrayKeyTypes($this->types)) {
            return true;
        }
        return \count($this->types) === 1;
    }

    private function arrayKeyTypes(array $types): bool
    {
        return $types == ['string', 'int'] || $types == ['int', 'string'];
    }
}
