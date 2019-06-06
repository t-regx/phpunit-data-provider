<?php
namespace TRegx\CrossData;

class DataProviders
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
     * @param array ...$dataProviders
     * @return DataProviders
     */
    public function input(array ...$dataProviders)
    {
        $this->dataProviders = $dataProviders;
        return $this;
    }

    /**
     * @param callable $mapper
     * @return DataProviders
     */
    public function keyMapper(callable $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return array
     */
    public function create()
    {
        return (new KeyMapper($this->mapper))->map((new ArrayMatrix())->cross($this->dataProviders));
    }

    /**
     * @return DataProvidersBuilder
     */
    public static function builder()
    {
        return new DataProvidersBuilder([], '\json_encode');
    }

    /**
     * @return DataProviders
     */
    public static function configure()
    {
        return new DataProviders([], '\json_encode');
    }

    /**
     * @param array ...$dataProviders
     * @return array
     */
    public static function crossAll(array ...$dataProviders)
    {
        return (new DataProviders($dataProviders, '\json_encode'))->create();
    }
}
