<?php

namespace App\Repositories\Dashboard;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;

class ProductRepository
{
    public function getProduct($id)
    {
        return Product::find($id);
    }
    public function getProductWithEgarLoading($id)
    {
        return Product::with('variants.variantAttributes')->find($id);
    }
    public function getProducts()
    {
        return Product::latest()->get();
    }
    public function createProduct($data)
    {
        return Product::create($data);
    }
    public function createProductVariant($data)
    {
        return ProductVariant::create($data);
    }
    public function createProductVariantAttribute($data)
    {
        return VariantAttribute::create($data);
    }
    public function updateProduct($product, $data)
    {
        return $product->update($data);
    }
    public function deleteProduct($product)
    {
        return $product->delete();
    }
    public function changeStatus($product, $status)
    {
        $product->status = $status;
        return $product->save();
    }
    public function deleteProductImage($imageId)
    {
        return ProductImage::find($imageId)->delete();
    }
    public function deleteProductVariants($productId)
    {
        return ProductVariant::where('product_id', $productId)->delete();
    }
}