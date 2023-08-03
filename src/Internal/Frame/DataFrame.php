<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Frame;

class DataFrame
{
    /** @var mixed[][] */
    private $dataProvider;

    public function __construct(array $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @return DataRow[]
     */
    public function dataset(): array
    {
        $sequential = $this->sequential($this->dataProvider);
        $dataset = [];
        foreach ($this->dataProvider as $key => $values) {
            $dataset[] = new DataRow([$key], [!$sequential], $values);
        }
        return $dataset;
    }

    private function sequential(array $array): bool
    {
        return \array_keys($array) === range(0, \count($array) - 1);
    }
}
