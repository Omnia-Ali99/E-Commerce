<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\BrandService;
use App\Services\Dashboard\ProductService;
use App\Services\Dashboard\CategoryService;
use App\Services\Dashboard\AttributeService;

class ProductController extends Controller
{
    protected $productService , $brandService , $categoryService , $attributeService;
    public function __construct(ProductService $productService , BrandService $brandService , CategoryService $categoryService , AttributeService $attributeService)
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.products.index');
    }
    public function getAll()
    {
        return $this->productService->getProductsForDatatables();
    }
    public function changeStatus(Request $request)
    {
        if ($this->productService->changeStatus($request)) {
            return response()->json([
                'status' => 'success',
                'message' => __('dashboard.success_msg'),
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Status not changed'
        ]);
    }
    public function create()
    {
        $brands = $this->brandService->getBrands();
        $categories = $this->categoryService->getCategories();
        return view('dashboard.products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->getProduct($id);
        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $productId   = $id;
       $categories  = $this->categoryService->getCategories();
       $brands      = $this->brandService->getBrands();
       $attributes  = $this->attributeService->getAttributes();

       return view('dashboard.products.edit' , compact('productId' , 'categories' , 'brands' , 'attributes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->productService->deleteProduct($id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg')
        ], 200);
    }

    public function deleteVariant($variant_id)
    {
        $variant = ProductVariant::find($variant_id);
        $product = $variant->product;
        if($product->variants->count() == 1){
            return redirect()->back()->with('error', 'You can not delete the last variant');
        }
        $variant->delete();
        return redirect()->back()->with('success', 'Variant deleted successfully');
    }
}