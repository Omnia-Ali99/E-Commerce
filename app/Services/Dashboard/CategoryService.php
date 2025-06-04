<?php

namespace App\Services\Dashboard;

use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    protected $categoryRepository;
     public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
      public function getCategories()
    {
        return $this->categoryRepository->getAll();
    }

   public function getCategoriesForDatatable()
    {
        $categories = $this->categoryRepository->getAll();

        return DataTables::of($categories)
        ->addIndexColumn()
        ->addColumn('name', function ($category) {
            return $category->getTranslation('name', app()->getLocale());
        })
        ->addColumn('status' , function ($category){
            return $category->getStatusTranslated();
        })
        ->addColumn('products_count' , function($category){
            return $category->products()->count() == 0 ? __('dashboard.not_found') : $category->products()->count();
        })
        ->addColumn('action', function ($category) {
           return view('dashboard.categories.actions'  ,compact('category'));
        })

        ->make(true);
    }

    public function store($data)
    {
        return $this->categoryRepository->store($data);
    }
    public function findById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function update($data)
    {
        $category = $this->categoryRepository->findById($data['id']);
        if(!$category){
            return false;
        }
        return $this->categoryRepository->update($category , $data);
    }
    public function delete($id)
    {
        $category = $this->categoryRepository->findById($id);
        return $this->categoryRepository->delete($category);
    }

    public function getParentCategories()
    {
        return $this->categoryRepository->getParentCategories();
    }



    public function getCategoriesExceptChildren($id)
    {
        return $this->categoryRepository->getCategoriesExceptChildren($id);
    }
}
