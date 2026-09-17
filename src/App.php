<?php

namespace Sibers;

use Sibers\DataSourceFactory;

class App
{
    public function run()
    {
        $source = $_GET['source'] ?? null;
        $page = $_GET['page'] ?? 1;
        $page = max($page, 1);

        $sources = DataSourceFactory::getSources();
        $result = null;
        $error  = null;

        if (isset($sources[$source])) {
            try {
                $result = DataSourceFactory::create($source)->getData($page, 10);
            } catch (\Throwable $e) {
                $error = 'An error occurred while fetching data: ' . $e->getMessage();
            }
        } else {
            $error = 'Unknown data source selected.';
        }

        $viewFile = __DIR__ . '/views/app.php';
        $data = compact('sources', 'source', 'result', 'error');

        extract($data, EXTR_SKIP);

        require $viewFile;
    }
}
