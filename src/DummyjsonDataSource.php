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

        if (!is_array($data)) {
            throw new \RuntimeException('Invalid response from ' . $this->getName() . ' API');
        }

        $data = $data['products'] ?? [];
        $allItems = [];

        foreach ($data as $item) {
            if (!is_array($item) || empty($item['title'])) {
                continue;
            }

            $allItems[] = [
                'title' => $item['title'] ?? 'No title',
                'url' => $item['url'] ?? '#',
                'description' => $item['description'] ?? 'No description',
            ];
        }

        $total = count($allItems);
        $offset = ($page - 1) * $perPage;
        $pageItems = array_slice($allItems, $offset, $perPage);

        return $this->buildResult($pageItems, $total, $page, $perPage);
    }
}
