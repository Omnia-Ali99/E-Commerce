<?php

namespace App\Livewire\Website;

use Livewire\Component;

class ProductPreview extends Component
{
    public $product;
    public $review;

    public function mount($product)
    {
        $this->product = $product;
        $this->product->load('productPreviews.user.country', 'productPreviews.user.city');
    }

    public function submitReview()
    {
        $this->validate([
            'review' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'review.required' => __('website.review_required'),
            'review.min' => __('website.review_min'),
            'review.max' => __('website.review_max'),
        ], [
            'review' => __('website.review_field'),
        ]);

        $this->product->productPreviews()->create([
            'comment' => trim($this->review),
            'user_id' => auth('web')->user()->id,
        ]);

        $this->reset('review');
        $this->product->refresh()->load('productPreviews.user.country', 'productPreviews.user.city');
        $this->dispatch('reviewSubmitted',__('website.review_submitted'));

    }

    public function render()
    {
        return view('livewire.website.product-preview');
    }


}