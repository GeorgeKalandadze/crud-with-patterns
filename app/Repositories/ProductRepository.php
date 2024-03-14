<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements Contracts\ProductRepositoryContract
{
    public function getAll()
    {
        return Product::all();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);

        return $product;
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }

    public function getById(int $id)
    {
        return Product::findOrFail($id);
    }
}
