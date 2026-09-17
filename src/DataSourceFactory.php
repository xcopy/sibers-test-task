<?php

namespace Sibers;

class DataSourceFactory
{
    private static array $sources = [
        DevtoDataSource::class,
        DummyjsonDataSource::class,
    ];

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
