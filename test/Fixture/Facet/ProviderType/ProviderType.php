<?php
namespace Test\Fixture\Facet\ProviderType;

abstract class ProviderType
{
    /**
     * This horrible hack is only present here, because of PHP
     * poor type system, in which children cannot extend the
     * return type, unlike literally every other language.
     */

    public function fromArray(array $dataProvider): iterable
    {
        return $this->toIterable($dataProvider);
    }

    /**
     * @return iterable
     */
    protected abstract function toIterable(array $dataProvider);
}
