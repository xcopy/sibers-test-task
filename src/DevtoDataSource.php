<?php

namespace Sibers;

class DevtoDataSource extends DataSource
{
    public function getName(): string
    {
        return 'DEV Community';
    }

    public function getId(): string
    {
        return 'devto';
    }

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
