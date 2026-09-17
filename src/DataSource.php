<?php

namespace Sibers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class DataSource implements DataSourceInterface
{
    protected function get(string $url): string
    {
        $cacheFile = __DIR__ . '/cache/' . md5($url) . '.json';

        if (file_exists($cacheFile)) {
            $cacheTime = filemtime($cacheFile);

            // cache is valid for 5 minutes
            if ($cacheTime !== false && (time() - $cacheTime) < 300) {
                return file_get_contents($cacheFile);
            }

            // cache is expired, delete it
            unlink($cacheFile);
        }

        try {
            $client = new Client([
                'headers' => ['accept' => 'application/json'],
            ]);

            // fetch the data from the API
            $response = (string) $client->get($url)->getBody();

            // save the response to cache
            if (!file_exists($cacheFile)) {
                file_put_contents($cacheFile, $response);
            }

            return $response;
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Failed to fetch data from: $url. Reason: " . $e->getMessage(), 0, $e);
        }
    }

    protected function processItems(array $data): array
    {
        $items = [];

        foreach ($data as $item) {
            if (!is_array($item) || empty($item['title'])) {
                continue;
            }

            $items[] = [
                'title' => $item['title'] ?? 'No title',
                'url' => $item['url'] ?? '#',
                'description' => $item['description'] ?? 'No description',
            ];
        }

        return $items;
    }

    protected function buildResult(mixed $data, int $page, int $perPage): array
    {
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid response from ' . $this->getName() . ' API');
        }

        $items = $this->processItems($data);

        $total = count($items);

        $offset = ($page - 1) * $perPage;

        if ($offset >= $total) {
            $offset = $total - $perPage;
            $page = (int) ceil($total / $perPage);
        }

        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
        $totalPages = max(1, $totalPages);

        $items = array_slice($items, $offset, $perPage);

        return compact('items', 'total', 'page', 'perPage', 'totalPages');
    }
}
