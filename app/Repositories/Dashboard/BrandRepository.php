<?php

namespace App\Repositories\Dashboard;

use App\Models\Brand;

class BrandRepository
{
   public function getBrands(){
    $brands = Brand::withCount('products')->latest()->get();
    return $brands;
   }
   public function getBrand($id)
   {
       $brand = Brand::find($id);
       return $brand;
   }
   public function createBrand($data)
   {
       $brand = Brand::create($data);
       return $brand;
   }
   public function updateBrand($brand, $data)
   {
      return $brand->update($data);
   }
   public function deleteBrand($brand)
   {
      return $brand->delete();
   }
}
