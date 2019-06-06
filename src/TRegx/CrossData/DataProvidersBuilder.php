<?php
namespace TRegx\CrossData;

class DataProvidersBuilder
{
    /** @var array */
    private $dataProviders;

    /** @var callable */
    private $mapper;

    public function __construct(array $dataProviders, callable $mapper)
    {
        $this->dataProviders = $dataProviders;
        $this->mapper = $mapper;
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
    public function keyMapper(callable $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return array
     */
    public function build()
    {
        return (new KeyMapper($this->mapper))->map((new ArrayMatrix())->cross($this->dataProviders));
    }
}
