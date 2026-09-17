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

        if (!is_array($data)) {
            throw new \RuntimeException('Invalid response from Dev.to API');
        }

        $allItems = [];
        foreach ($data as $article) {
            if (!is_array($article) || empty($article['title'])) {
                continue;
            }

            $allItems[] = [
                'title' => $article['title'] ?? 'No title',
                'url' => $article['url'] ?? '#',
                'description' => $article['description'] ?? '',
            ];
        }

        $total = count($allItems);
        $offset = ($page - 1) * $perPage;
        $pageItems = array_slice($allItems, $offset, $perPage);

        return $this->buildResult($pageItems, $total, $page, $perPage);
    }
}
