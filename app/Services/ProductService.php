<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Repositories\Contracts\ImageRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(
        public ProductRepositoryContract $productRepositoryContract,
        public ImageRepositoryContract $imageRepositoryContract
    ) {

    }

    public function getAllProducts()
    {
        return $this->productRepositoryContract->getAll()->load('images');
    }

    public function createProduct(ProductRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $productData = $request->validated();
            $product = $this->productRepositoryContract->create($productData);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images');
                    $imageData = ['url' => $path, 'product_id' => $product->id];
                    $this->imageRepositoryContract->create($imageData);
                }
            }

            return $product;
        });
    }

    public function updateProduct(int $id, ProductRequest $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $productData = $request->validated();
            $product = $this->productRepositoryContract->update($id, $productData);
            if ($request->hasFile('images')) {
                $this->imageRepositoryContract->delete($product->id);
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images');
                    $imageData = ['url' => $path, 'product_id' => $product->id];
                    $this->imageRepositoryContract->create($imageData);
                }
            }

            return $product;
        });
    }

    public function deleteProduct(int $id)
    {
        return DB::transaction(function () use ($id) {
            $product = $this->productRepositoryContract->getById($id);
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->url);
                $this->imageRepositoryContract->delete($image->id);
            }

            return $this->productRepositoryContract->delete($id);
        });
    }

    public function getProductById(int $id)
    {
        return $this->productRepositoryContract->getById($id)->load('images');
    }
}
