<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Attribute;
use Livewire\WithFileUploads;
use App\Services\Dashboard\ProductService;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $successMessage = '';
    public $brands, $categories;
    public $images, $tags, $discount, $start_discount, $end_discount, $quantity, $price, $sku;
    public $name_ar, $name_en, $desc_ar, $desc_en, $small_desc_ar, $small_desc_en, $category_id, $brand_id, $available_for;
    public $has_variants = 0, $manage_stock = 0, $has_discount = 0;
    public $prices = [], $quantities = [], $attributeValues = [];
    public $fullscreenImage = '';
    public $valueRowCount = 1;

    protected ProductService $productService;
    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function mount($categories, $brands)
    {
        $this->categories = $categories;
        $this->brands = $brands;
    }

    public function addNewVariant()
    {
        $this->prices[] = null;
        $this->quantities[] = null;
        $this->attributeValues[] = [];
        $this->valueRowCount = count($this->prices); // Keep count synchronized
    }

    public function removeVariant()
    {
        if ($this->valueRowCount > 1) {
            $this->valueRowCount--;
            array_pop($this->prices);
            array_pop($this->quantities);
            array_pop($this->attributeValues);
        }
    }
    public function deleteImage($key)
    {
        unset($this->images[$key]);
    }
    public function openFullscreen($key)
    {
        $this->fullscreenImage = $this->images[$key]->temporaryUrl();
        $this->dispatch('showFullscreenModal');
    }
    public function updatedFile()
    {
        $this->resetErrorBag('images'); // Clears validation error for the file field
    }
    public function firstStepSubmit()
    {
        $this->validate([
            'name_ar'       => ['required', 'string', 'max:80'],
            'name_en'       => ['required', 'string', 'max:80'],
            'desc_ar'       => ['required', 'string', 'max:1000'],
            'desc_en'       => ['required', 'string', 'max:1000'],
            'small_desc_ar' => ['required', 'string', 'max:150'],
            'small_desc_en' => ['required', 'string', 'max:150'],
            'sku'           => ['required', 'string', 'max:30'],
            'category_id'   => ['required', 'exists:categories,id'],
            'brand_id'      => ['required', 'exists:brands,id'],
            'available_for' => ['required', 'date'],
            'tags'         =>  ['required', 'string'],
        ]);

        $this->currentStep = 2;
    }
    public function secondStepSubmit()
    {
        $data = [
            'has_variants'  => ['required', 'in:1,0'],
            'manage_stock'  => ['required', 'in:0,1'],
            'has_discount'  => ['required', 'in:1,0'],
        ];
        if ($this->has_variants == 0) {
            $data['price'] = ['required', 'numeric', 'min:1', 'max:1000000'];
        }
        if ($this->manage_stock == 1 && $this->has_variants == 0) {
            $data['quantity'] = ['required', 'min:1', 'max:1000000'];
        }
        if ($this->has_discount == 1) {
            $data['discount'] = ['required', 'numeric', 'min:1', 'max:100'];
            $data['start_discount'] = ['date', 'before:end_discount'];
            $data['end_discount']  = ['date', 'after:start_discount'];
        }
        if ($this->has_variants == 1) {
            $data['prices'] = 'required|array|min:1';
            $data['prices.*'] = 'required|numeric|min:1|max:1000000';
            $data['quantities'] = 'required|array|min:1';
            $data['quantities.*'] = 'required|integer|min:0';
            $data['attributeValues'] = 'required|array|min:1';
            $data['attributeValues.*'] = 'required|array';
            $data['attributeValues.*.*'] = 'required|integer|exists:attribute_values,id';
        }

        $this->validate($data);
        $this->currentStep = 3;
    }
    public function thirdStepSubmit()
    {
        $this->validate([
            'images' => ['required', 'array'],
        ]);
        $this->currentStep = 4;
    }

    public function submitForm()
    {
        // create simple product
        $product = [
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'desc' => ['ar' => $this->desc_ar, 'en' => $this->desc_en],
            'small_desc' =>  ['ar' => $this->small_desc_ar, 'en' => $this->small_desc_en],
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'sku' => $this->sku,
            'available_for' => $this->available_for,
            'has_variants' => $this->has_variants,
            'price' => $this->has_variants == 1 ? null : $this->price,
            'manage_stock' => $this->has_variants == 1 ? 1 :  $this->manage_stock,
            'quantity' => $this->manage_stock == 0 ? null : $this->quantity,
            'has_discount' => $this->has_discount,
            'discount' => $this->has_discount == 0 ? null : $this->discount,
            'start_discount' => $this->has_discount == 0 ? null : $this->start_discount,
            'end_discount' => $this->has_discount == 0 ? null : $this->end_discount,
        ];

        // store variants
        $productVariants = [];
        if ($this->has_variants) {
            foreach ($this->prices as $index => $price) {
                $productVariants[] = [
                    'product_id' => null,
                    'price' => $price,
                    'stock' => $this->quantities[$index] ?? 0,
                    'attriubte_value_ids' => $this->attributeValues[$index],
                ];
            }
        }

        $this->productService->createProductWithDetails($product, $productVariants, $this->images);

        $this->successMessage = 'Product Created Successfully.';
        $this->resetExcept(['categories', 'brands', 'successMessage']);
        $this->currentStep = 1;
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function render()
    {
        $attributes = Attribute::with('attributeValues')->get();
        return view('livewire.dashboard.create-product', [
            'attributes' => $attributes
        ]);
    }
}
