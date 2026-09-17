<?php

namespace Sibers;

interface DataSourceInterface
{
    public function getName(): string;

    public function getId(): string;

    public function getData(int $page, int $perPage): array;
}
