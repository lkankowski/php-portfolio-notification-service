<?php

declare(strict_types=1);

namespace App\Eshop\Application;

use App\Eshop\Infrastructure\ProductRepository;

final class ProductService
{
    public function __construct(private readonly ProductRepository $repository)
    {
    }

    public function listProducts(QueryParamsData $queryParams): iterable
    {
        $data = $this->repository->findPage($queryParams->limit, $queryParams->offset);
        $count = $this->repository->countAll();

        return [
            'data' => $data,
            'pager' => $this->calculatePager($queryParams, $count),
        ];
    }

    private function calculatePager(QueryParamsData $queryParams, int $count): PagerData
    {
        $last = (int) ceil($count / $queryParams->limit);
        return new PagerData(
            1,
            $last,
            \max($queryParams->offset - 1, 1),
            \min($queryParams->offset + 1, $last),
        );
    }
}
