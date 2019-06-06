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

    public function input(array ...$dataProviders): DataProviders
    {
        $this->dataProviders = $dataProviders;
        return $this;
    }

    public function keyMapper(callable $mapper): DataProviders
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function create(): array
    {
        return (new KeyMapper($this->mapper))->map((new ArrayMatrix())->cross($this->dataProviders));
    }

    public static function configure(): DataProviders
    {
        return new DataProviders([], '\json_encode');
    }

    public static function crossAll(array ...$dataProviders): array
    {
        return (new DataProviders($dataProviders, '\json_encode'))->create();
    }
}
