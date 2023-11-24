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
            foreach ($this->associativeKeys($dataRow) as $key) {
                $types[$this->typeOf($key)] = true;
            }
        }
        return \array_keys($types);
    }

    private function associativeKeys(DataRow $row): \Iterator
    {
        foreach ($row->keys as $index => $key) {
            if ($row->isAssociative($index)) {
                yield $key;
            }
        }
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

    private function typeOf($value): string
    {
        return new Type($value);
    }
}
