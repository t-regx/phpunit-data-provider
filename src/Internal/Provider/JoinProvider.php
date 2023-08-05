<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

use TRegx\PhpUnit\DataProviders\DataProvider;
use TRegx\PhpUnit\DataProviders\Internal\Frame\InputProviders;
use TRegx\PhpUnit\DataProviders\IrregularDataProviderException;

class JoinProvider extends DataProvider
{
    /** @var InputProviders */
    private $inputProviders;

    public function __construct(array $dataProviders)
    {
        $this->inputProviders = new InputProviders($dataProviders);
    }

    protected function dataset(): array
    {
        $dataset = $this->joinedDataset();
        if ($this->datasetUniform($dataset)) {
            return $dataset;
        }
        throw new IrregularDataProviderException('Failed to join data providers with different amounts of parameters in rows');
    }

    private function datasetUniform(array $dataset): bool
    {
        $columns = new UniformSize();
        foreach ($dataset as $row) {
            $columns->next(\count($row->values));
        }
        return $columns->uniform();
    }

    private function joinedDataset(): array
    {
        $dataset = [];
        foreach ($this->inputProviders->dataFrames() as $dataProvider) {
            foreach ($dataProvider->dataset() as $row) {
                $dataset[] = $row;
            }
        }
        return $dataset;
    }
}
