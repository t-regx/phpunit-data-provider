<?php
namespace TRegx\PhpUnit\DataProviders\Internal\View\Duplicates;

use TRegx\PhpUnit\DataProviders\Internal\View\ViewRow;

class ViewRowKeyset
{
    /** @var Set */
    private $set;

    /**
     * @param ViewRow[] $viewRows
     */
    public function __construct(array $viewRows)
    {
        $this->set = new Set();
        foreach ($viewRows as $row) {
            $this->set->add($row->formatKeys(false));
        }
    }

    public function isDuplicate(ViewRow $row): bool
    {
        return $this->set->isDuplicate($row->formatKeys(false));
    }
}
