<?php
namespace TRegx\CrossData;

class DataProviders
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
    public function mapper(callable $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @param callable $keyMapper
     * @return DataProviders
     */
    public function keyMapper(callable $keyMapper)
    {
        $this->keyMapper = $keyMapper;
        return $this;
    }

    /**
     * @return array
     */
    public function create()
    {
        $result = (new ArrayMatrix())->cross($this->dataProviders);
        $mapped = (new KeyMapper($this->keyMapper))->map($result);
        if ($this->mapper !== null) {
            $mapped = \array_map(function ($input) {
                return (array)$input;
            }, \array_map($this->mapper, $mapped));
        }
        return $mapped;
    }

    /**
     * @return DataProvidersBuilder
     */
    public static function builder()
    {
        return new DataProvidersBuilder([], null, '\json_encode');
    }

    /**
     * @return DataProviders
     */
    public static function configure()
    {
        return new DataProviders([], null, '\json_encode');
    }

    /**
     * @param array ...$dataProviders
     * @return array
     */
    public static function crossAll(array ...$dataProviders)
    {
        return (new DataProviders($dataProviders, null, '\json_encode'))->create();
    }
}
