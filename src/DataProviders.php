<?php

declare(strict_types=1);

namespace TRegx\DataProvider;

class DataProviders
{
    /** @var iterable[] */
    private $dataProviders;

    /** @var callable|null */
    private $mapper;

    /** @var callable */
    private $keyMapper;

    /**
     * @param iterable[] $dataProviders
     */
    public function __construct(array $dataProviders, ?callable $mapper, callable $keyMapper)
    {
        $this->dataProviders = $dataProviders;
        $this->mapper = $mapper;
        $this->keyMapper = $keyMapper;
    }

    /**
     * @return array<string|int, array<int, mixed>>
     */
    public function create(): iterable
    {
        $result = (new ArrayMatrix())->cross($this->dataProviders);
        $entries = (new KeyMapper($this->keyMapper))->map($result);
        if ($this->mapper !== null) {
            $entries = $this->mapEntries($entries);
        }

        yield from $this->validateDataProviders($entries);
    }

    public static function builder(): DataProvidersBuilder
    {
        return new DataProvidersBuilder([], null, '\json_encode');
    }

    public static function cross(iterable ...$dataProviders): iterable
    {
        return (new DataProviders($dataProviders, null, '\json_encode'))->create();
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateDataProviders(iterable $entries): \Generator
    {
        foreach ($entries as $key => $value) {
            if (!is_array($value)) {
                $message = sprintf("Argument list is supposed to be an array, '%s' given", gettype($value));
                throw new \InvalidArgumentException($message);
            }
            if (array_values($value) !== $value) {
                throw new \InvalidArgumentException("Arguments composed of an associative array");
            }

            yield $key => $value;
        }
    }

    private function mapEntries(iterable $entries) : \Generator
    {
        foreach($entries as $key => $value) {
            yield $key => (array)($this->mapper)($value);
        }
    }

    public static function pairs(...$values): array
    {
        return DataProviderPairs::getMixedPairs($values);
    }

    public static function distinctPairs(...$values): array
    {
        return DataProviderPairs::getDistinctPairs($values);
    }

    public static function each(array $array): array
    {
        return DataProvidersEach::each($array);
    }

    public static function eachNamed(array $array)
    {
        return DataProvidersEach::eachNamed($array);
    }
}
