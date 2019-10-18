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
     * @return array
     */
    public function create()
    {
        $result = (new ArrayMatrix())->cross($this->dataProviders);
        $entries = (new KeyMapper($this->keyMapper))->map($result);
        if ($this->mapper !== null) {
            $entries = $this->mapEntries($entries);
        }

        $this->validateDataProviders($entries);
        return $entries;
    }

    /**
     * @return DataProvidersBuilder
     */
    public static function builder()
    {
        return new DataProvidersBuilder([], null, '\json_encode');
    }

    /**
     * @param array ...$dataProviders
     * @return array
     */
    public static function cross(array ...$dataProviders)
    {
        return (new DataProviders($dataProviders, null, '\json_encode'))->create();
    }

    private function validateDataProviders(array $entries)
    {
        foreach ($entries as $value) {
            if (!is_array($value)) {
                throw new \InvalidArgumentException(sprintf("Argument list is supposed to be an array, '%s' given", gettype($value)));
            }
            if (array_values($value) !== $value) {
                throw new \InvalidArgumentException("Arguments composed of an associative array");
            }
        }
    }

    private function mapEntries(array $entries)
    {
        return \array_map(function ($input) {
            return (array)$input;
        }, \array_map($this->mapper, $entries));
    }
}
