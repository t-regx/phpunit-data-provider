<?php
namespace TRegx\PhpUnit\DataProviders\Internal\Provider;

class UniformSize
{
    /** @var int|null */
    private $lastSize = null;
    /** @var bool */
    private $even = true;

    public function next(int $size): void
    {
        if ($this->lastSize === null) {
            $this->lastSize = $size;
        } else {
            if ($this->lastSize !== $size) {
                $this->even = false;
            }
        }
    }

    public function uniform(): bool
    {
        return $this->even;
    }
}
