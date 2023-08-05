<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class ReindexedDataFrame extends DataFrame
{
    /** @var DataFrame */
    private $frame;

    public function __construct(DataFrame $frame)
    {
        $this->frame = $frame;
    }

    public function dataset(): array
    {
        $dataset = $this->frame->dataset();
        if (empty($dataset)) {
            return [];
        }
        return $this->reindexedRows($dataset);
    }

    /**
     * @param DataRow[] $dataRows
     * @return DataRow[]
     */
    private function reindexedRows(array $dataRows): array
    {
        for ($i = 0; $i < \count($dataRows[0]->keys); $i++) {
            $sequence = 0;
            foreach ($dataRows as $row) {
                if (isset($row->keys[$i])) {
                    if (!$row->isAssociative($i)) {
                        $row->keys[$i] = $sequence++;
                    }
                }
            }
        }
        return $dataRows;
    }
}
