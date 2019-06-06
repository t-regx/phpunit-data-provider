<?php
namespace TRegx\CrossData;

class DataProviders
{
    /** @var array */
    private $dataProviders;

    /** @var callable */
    private $mapper;

    public function __construct(array $dataProviders)
    {
        $this->dataProviders = $dataProviders;
        $this->mapper = '\json_encode';
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

    public static function input(array ...$dataProviders): DataProviders
    {
        return new DataProviders($dataProviders);
    }

    public static function cross(array ...$dataProviders): array
    {
        return (new DataProviders($dataProviders))->create();
    }
}
