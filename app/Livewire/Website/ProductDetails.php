<?php

namespace App\Livewire\Website;

use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;

class ProductDetails extends Component
{
    public $product;
    public $variantId;
    public $quantity;
    public $price;

    public $cartQuantity = 1;
    public $productId;
    public $cartAttributesArray = []; // [attribute_id => attribute_value_id]

    public function mount($product)
    {
        $this->product   = $product;
        $this->variantId = $product->has_variants ? $this->product->variants->first()->id : null;
        $this->price     = $product->has_variants ? $this->product->variants->first()->price : null;
        $this->quantity  = $product->has_variants ? $this->product->variants->first()->stock : $product->quantity;
    }

    public function changeVariant($variantId)
    {
        $variant = $this->product->variants->find($variantId);
        if (!$variant) {
            return response()->json(['message' => 'Invalid variant'], 404);
        }

        $this->changePropertiesValues($variant);
    }

    public function changePropertiesValues($variant)
    {
        $this->variantId = $variant->id;
        $this->price     = $variant->price;
        $this->quantity  = $variant->stock;
    }


    // cart function
    public function incrementCartQuantity()
    {
        $this->cartQuantity++;
    }
    public function decrementCartQuantity()
    {
        if ($this->cartQuantity > 1) {
            $this->cartQuantity--;
        }
    }


    public function addToCart()
    {
        $product = $this->product;
        $userId = auth('web')->user()->id;
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        if (!$product->has_variants) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->whereNull('product_variant_id')
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $this->cartQuantity);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'price' => $product->has_discount ? $product->price - $product->discount : $product->price,
                    'quantity' => $this->cartQuantity,
                ]);
            }
        }

        if ($product->has_variants) {
            $variant = $product->variants->find($this->variantId);
            $variant->load('VariantAttributes');

            // Check if the same variant already exists in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $variant->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $this->cartQuantity);
            } else {

                foreach ($variant->VariantAttributes as $variantAttr) {
                    $this->cartAttributesArray[$variantAttr->attributeValue->attribute->name] = $variantAttr->attributeValue->value;
                }

                $item = $cart->items()->create([
                    'product_id' => $product->id,
                    'product_variant_id' => $this->variantId,
                    'price' => $variant->price,
                    'quantity' => $this->cartQuantity,
                    'attributes' => json_encode($this->cartAttributesArray, JSON_UNESCAPED_UNICODE)
                ]);
            }
        }

        $this->dispatch('successMessage', __('website.product_added_to_cart'));
        $this->dispatch('refreshCartIcon');
    }

    public function render()
    {
        return view('livewire.website.product-details', [
            'variants' => $this->product->variants,
        ]);
    }
}
