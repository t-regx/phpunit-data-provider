<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

class IdempotentDataProviderIterator implements \IteratorAggregate
{
    /** @var bool */
    private $sequential = true;
    /** @var array[] */
    private $entries = [];

    public function __construct(iterable $dataProvider)
    {
        $index = 0;
        foreach ($dataProvider as $key => $value) {
            $this->entries[] = [$key, $value];
            if ($key !== $index++) {
                $this->sequential = false;
            }
        }
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->entries as [$key, $value]) {
            yield $key => $value;
        }
    }

    public function sequential(): bool
    {
        return $this->sequential;
    }
}
