<?php

namespace Sibers;

class DummyjsonDataSource extends DataSource
{
    public function getName(): string
    {
        return 'DummyJSON';
    }

    public function getId(): string
    {
        return 'dummyjson';
    }

    public function getData(int $page, int $perPage): array
    {
        $url = 'https://dummyjson.com/products?' . http_build_query([
            'limit' => 100,
        ]);

        $json = $this->get($url);
        $data = json_decode($json, true);
        $data = is_array($data) ? ($data['products'] ?? []) : [];

        return $this->buildResult($data, $page, $perPage);
    }
}
