<?php

namespace Sibers;

/**
 * Class DevtoDataSource
 *
 * This class represents a data source that fetches articles from the DEV Community API.
 */
class DevtoDataSource extends DataSource
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'DEV Community Articles';
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return 'devto';
    }

    /**
     * @inheritDoc
     */
    public function getData(int $page, int $perPage): array
    {
        $url = 'https://dev.to/api/articles?' . http_build_query([
            'per_page' => 100,
            'page' => 1,
        ]);

        $json = $this->get($url);
        $data = json_decode($json, true);

        return $this->buildResult($data, $page, $perPage);
    }
}
