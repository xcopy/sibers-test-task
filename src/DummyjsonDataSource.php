<?php

namespace Sibers;

class DummyjsonDataSource extends DataSource
{
    public function getName(): string
    {
        return 'DummyJSON Products';
    }

    public function getId(): string
    {
        return 'dummyjson';
    }

    protected function processItems(array $data): array
    {
        $items = parent::processItems($data);

        foreach ($items as $i => &$item) {
            $item['thumbnail'] = $data[$i]['thumbnail'] ?? null;
        }

        return $items;
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
