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

    public function crossing(array $singleDataProvider): DataProvidersBuilder
    {
        $this->dataProviders[] = $singleDataProvider;
        return $this;
    }

    public function keyMapper(callable $mapper): DataProvidersBuilder
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function build(): array
    {
        return (new KeyMapper($this->mapper))->map((new ArrayMatrix())->cross($this->dataProviders));
    }
}
