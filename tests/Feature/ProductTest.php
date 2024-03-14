<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_create_product_with_fake_images()
    {
        $image1 = UploadedFile::fake()->create('image1.png', 100);
        $image2 = UploadedFile::fake()->create('image2.png', 200);

        $response = $this->json('POST', '/api/products', [
            'name' => 'Product 1',
            'description' => 'This is my first product',
            'price' => 99,
            'images' => [$image1, $image2],
        ]);

        $response->assertStatus(201);

        $product = Product::first();
        $this->assertNotNull($product);

        $this->assertCount(2, $product->images);
        foreach ($product->images as $image) {
            $this->assertStringContainsString('image', $image->url);
        }
    }
}
