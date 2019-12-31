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

    public function create(): array
    {
        $result = (new ArrayMatrix())->cross($this->dataProviders);
        $entries = (new KeyMapper($this->keyMapper))->map($result);
        if ($this->mapper !== null) {
            $entries = $this->mapEntries($entries);
        }

        $this->validateDataProviders($entries);
        return $entries;
    }

    public static function builder(): DataProvidersBuilder
    {
        return new DataProvidersBuilder([], null, '\json_encode');
    }

    public static function cross(array ...$dataProviders): array
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

    private function mapEntries(array $entries): array
    {
        return \array_map(function ($input) {
            return (array)$input;
        }, \array_map($this->mapper, $entries));
    }
}
