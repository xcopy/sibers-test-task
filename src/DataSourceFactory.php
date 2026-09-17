<?php

namespace Sibers;

class DataSourceFactory
{
    private static array $sources = [
        'devto' => DevtoDataSource::class,
        'dummyjson' => DummyjsonDataSource::class,
    ];

    public static function getSources(): array
    {
        $result = [];

        foreach (self::$sources as $id => $class) {
            /** @var DataSourceInterface $instance */
            $instance = new $class();
            $result[$id] = $instance->getName();
        }

        return $result;
    }

    public static function create(string $id): DataSourceInterface
    {
        if (!isset(self::$sources[$id])) {
            throw new \InvalidArgumentException("Unknown data source: $id");
        }

        $class = self::$sources[$id];

        return new $class();
    }
}
