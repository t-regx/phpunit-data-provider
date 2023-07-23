<?php
namespace TRegx\PhpUnit\DataProviders\Internal;

use TRegx\PhpUnit\DataProviders\DataProvider;

/**
 * {@see DataProvider} is the library's public interface,
 * intended to be passed to PhpUnit in "@dataProvider" annotation.
 *
 * Additionally, it can also be passed back into other the library
 * entry points, to be crossed, zipped or joined. In order to properly
 * present array keys without scraping strings, we need to access
 * the datasets from the {@see DataProvider} internals..
 *
 * An alternative would be to expose two classes - one with entry point
 * facade methods, and the other one being the data provider object.
 * Out of two evils, protected method {@see DataProvider::dataset()} is
 * probably the more suitable choice.
 *
 * {@see DataProvider::dataset()} should remain a protected method,
 * not to unnecessarily confuse users of the interface with the method.
 * {@see DataProvider::dataset()} is not supposed to be called by the
 * user of the interface - only by the library entry points, when
 * already exposed {@see DataProvider} is passed back into the
 * entry points.
 *
 * Class {@see BrokenEncapsulationDataProvider} extends {@see DataProvider}
 * to access {@see DataProvider::dataset()} without, using unhealthy
 * hacks.
 */
class BrokenEncapsulationDataProvider extends DataProvider
{
    /** @var DataProvider */
    private $provider;

    public function __construct(DataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return DataRow[]
     */
    public function dataset(): array
    {
        return $this->provider->dataset();
    }
}
