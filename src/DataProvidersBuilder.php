<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class DataProvidersBuilder
{
    /** @var iterable[] */
    private $dataProviders;

    /** @var callable|null */
    private $mapper;

    /** @var callable */
    private $keyMapper;

    /**
     * @param iterable[]    $dataProviders
     * @param callable|null $mapper
     * @param callable $keyMapper
     */
    public function __construct(array $dataProviders, ?callable $mapper, callable $keyMapper)
    {
        $this->dataProviders = $dataProviders;
        $this->mapper = $mapper;
        $this->keyMapper = $keyMapper;
    }

    public function addSection(...$singleDataProvider): DataProvidersBuilder
    {
        $this->dataProviders[] = array_map(function ($value) {
            return [$value];
        }, $singleDataProvider);
        return $this;
    }

    public function addJoinedSection(iterable ...$sections): DataProvidersBuilder
    {
        $this->dataProviders[] = $sections;
        return $this;
    }

    public function entryMapper(callable $mapper): DataProvidersBuilder
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function entryKeyMapper(callable $mapper): DataProvidersBuilder
    {
        $this->keyMapper = $mapper;
        return $this;
    }

    public function build(): iterable
    {
        return (new DataProviders($this->dataProviders, $this->mapper, $this->keyMapper))->create();
    }
}
