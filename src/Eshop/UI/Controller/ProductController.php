<?php

namespace App\Eshop\UI\Controller;

use App\Eshop\Application\PagerData;
use App\Eshop\Application\ProductService;
use App\Eshop\Application\QueryParamsData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
    )
    {
    }

    #[Route('/products', name: 'app_product_query', methods: [Request::METHOD_GET])]
    public function query(Request $request): Response
    {
        $data = $this->productService->listProducts($this->mapRequestToPager($request));

        return new JsonResponse($data);
    }

    #[Route('/products/{id}', name: 'app_product_details', methods: [Request::METHOD_GET])]
    public function details(): Response
    {
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/products', name: 'app_product_add', methods: [Request::METHOD_POST])]
    public function add(): Response
    {
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/products/{id}', name: 'app_product_remove', methods: [Request::METHOD_DELETE])]
    public function remove(): Response
    {
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/products/{id}', name: 'app_product_update', methods: [Request::METHOD_PUT])]
    public function update(): Response
    {
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    private function mapRequestToPager(Request $request): QueryParamsData
    {
        return new QueryParamsData(1, 3);
    }
}
