<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View;

use TRegx\PhpUnit\DataProviders\Internal\Frame\DataFrame;
use TRegx\PhpUnit\DataProviders\Internal\Frame\DataRow;

class ReindexedKeysDataFrame extends DataFrame
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
        for ($i = 0; $i < $this->widestRowWidth($dataRows); $i++) {
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

    /**
     * @param DataRow[] $dataRows
     * @return int
     */
    private function widestRowWidth(array $dataRows): int
    {
        return max(\array_map(function (DataRow $row): int {
            return \count($row->keys);
        }, $dataRows));
    }
}
