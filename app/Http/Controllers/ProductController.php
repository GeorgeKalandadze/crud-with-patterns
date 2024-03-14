<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(public ProductService $productService)
    {

    }

    public function index()
    {
        $products = $this->productService->getAllProducts();

        return response()->json($products);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request);

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        return response()->json($product);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productService->updateProduct($id, $request);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return response()->json(null, 204);
    }
}
