<?php

namespace Sibers;

/**
 * Interface DataSourceInterface
 *
 * This interface defines the contract for data source classes that fetch data from external APIs.
 * Any class implementing this interface must provide methods to get the name, ID, and data of the source.
 */
interface DataSourceInterface
{
    /**
     * Returns the name of the data source.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the unique identifier of the data source.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Fetches data from the data source for the specified page and number of items per page.
     *
     * @param int $page The page number to fetch.
     * @param int $perPage The number of items per page.
     *
     * @return array
     */
    public function getData(int $page, int $perPage): array;
}
