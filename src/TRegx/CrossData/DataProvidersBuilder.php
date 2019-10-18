<?php
namespace TRegx\CrossData;

class DataProvidersBuilder
{
    /** @var array[] */
    private $dataProviders;

    /** @var callable|null */
    private $mapper;

    /** @var callable */
    private $keyMapper;

    public function __construct(array $dataProviders, $mapper, callable $keyMapper)
    {
        $this->dataProviders = $dataProviders;
        $this->mapper = $mapper;
        $this->keyMapper = $keyMapper;
    }

    /**
     * @param array[] $singleDataProvider
     * @return DataProvidersBuilder
     */
    public function addSection(...$singleDataProvider)
    {
        $this->dataProviders[] = array_map(function ($value) {
            return [$value];
        }, $singleDataProvider);
        return $this;
    }

    /**
     * @param array ...$sections
     * @return DataProvidersBuilder
     */
    public function addJoinedSection(array ...$sections)
    {
        $this->dataProviders[] = $sections;
        return $this;
    }

    /**
     * @param callable $mapper
     * @return DataProvidersBuilder
     */
    public function entryMapper(callable $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @param callable $mapper
     * @return DataProvidersBuilder
     */
    public function entryKeyMapper(callable $mapper)
    {
        $this->keyMapper = $mapper;
        return $this;
    }

    /**
     * @return array
     */
    public function build()
    {
        return (new DataProviders($this->dataProviders, $this->mapper, $this->keyMapper))->create();
    }
}
