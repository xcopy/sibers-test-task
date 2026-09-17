<?php

namespace Sibers;

/**
 * Class DataSourceFactory
 *
 * This factory class is responsible for creating instances of data source classes based on their IDs.
 * It also maintains a list of available data source classes and provides methods to retrieve them.
 */
class DataSourceFactory
{
    /**
     * @var array An array of available data source classes.
     */
    private static array $sources = [
        DevtoDataSource::class,
        DummyjsonDataSource::class,
    ];

    /**
     * Returns an associative array of available data sources,
     * where the keys are the source IDs and the values are the source names.
     *
     * @return array An associative array of available data sources.
     */
    public static function getSources(): array
    {
        $result = [];

        foreach (self::$sources as $class) {
            /** @var DataSourceInterface $instance */
            $instance = new $class();
            $result[$instance->getId()] = $instance->getName();
        }

        return $result;
    }

    /**
     * Creates an instance of the specified data source class based on the provided ID.
     *
     * @param string $id The ID of the data source to create.
     * @throws \InvalidArgumentException If the specified data source ID is unknown.
     *
     * @return DataSourceInterface An instance of the specified data source class.
     */
    public static function create(string $id): DataSourceInterface
    {
        foreach (self::$sources as $class) {
            /** @var DataSourceInterface $instance */
            $instance = new $class();

            if ($instance->getId() === $id) {
                return $instance;
            }
        }

        throw new \InvalidArgumentException("Unknown data source: $id");
    }
}
