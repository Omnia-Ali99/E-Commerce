<?php

namespace App\Livewire\Website\Dashboard;

use App\Models\ProductPreview;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Review;

class Reviews extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $screen = 'dashboard';
    public $auth_user;

    public $showModal = false;
    public $editReviewId;
    public $editReviewComment;

    public function mount($auth_user)
    {
        $this->auth_user = $auth_user;
    }

    #[On('reviewSelectScreen')]
    public function selectScreen($screen)
    {
        $this->screen = $screen;
    }

    public function editReview($id)
    {
        $review = ProductPreview::find($id);
        $this->editReviewId = $review->id;
        $this->editReviewComment = $review->comment;
        $this->showModal = true;
    }

    public function updateReview()
    {
        $this->validate([
            'editReviewComment' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'editReviewComment.required' => __('website.review_required'),
            'editReviewComment.min' => __('website.review_min'),
            'editReviewComment.max' => __('website.review_max'),
        ], [
            'editReviewComment' => __('website.review_field'),
        ]);

        $review = ProductPreview::find($this->editReviewId);
        $review->update([
            'comment' => trim($this->editReviewComment),
        ]);

        $this->showModal = false;
        $this->dispatch('reviewUpdated' , __('website.review_updated_successfully'));
    }

    #[On('deleteReview')]
    public function deleteReview($reviewId)
    {
        ProductPreview::find($reviewId)->delete();
        $this->dispatch('reviewDeleted' , __('website.review_deleted_successfully'));
    }

    public function render()
    {
        $reviews = $this->auth_user
            ->reviews()
            ->with('product.images')
            ->latest()
            ->paginate(4);

        return view('livewire.website.dashboard.reviews', compact('reviews'));
    }
}