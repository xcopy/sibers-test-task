<?php

namespace Sibers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class DataSource implements DataSourceInterface
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'headers' => ['accept' => 'application/json'],
        ]);
    }

    protected function get(string $url): string
    {
        try {
            $response = $this->httpClient->get($url);
            return (string) $response->getBody();
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Failed to fetch data from: {$url}. Reason: " . $e->getMessage(), 0, $e);
        }
    }

    protected function buildResult(array $items, int $total, int $page, int $perPage): array
    {
        $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
        $totalPages = max(1, $totalPages);

        return compact('items', 'total', 'page', 'perPage', 'totalPages');
    }
}
