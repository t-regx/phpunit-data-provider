<?php
namespace TRegx\CrossData;

class DataProvidersBuilder
{
    /** @var array */
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
     * @param array $singleDataProvider
     * @return DataProvidersBuilder
     */
    public function crossing(array $singleDataProvider)
    {
        $this->dataProviders[] = $singleDataProvider;
        return $this;
    }

    /**
     * @param callable $mapper
     * @return DataProvidersBuilder
     */
    public function mapper(callable $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @param callable $mapper
     * @return DataProvidersBuilder
     */
    public function keyMapper(callable $mapper)
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
