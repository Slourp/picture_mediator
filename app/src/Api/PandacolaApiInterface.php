<?php

namespace App\Api;

interface PandacolaApiInterface
{
    public function getProducts(int $page = 1, int $size = 100): array;

    public function getProductBySku(string $sku): ?array;
}
