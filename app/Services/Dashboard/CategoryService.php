<?php

namespace App\Services\Dashboard;

use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\CategoryRepository;
use App\Utils\ImageManger;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    protected $categoryRespository, $imageManager;
    public function __construct(CategoryRepository $categoryRespository, ImageManger $imageManager)
    {
        $this->categoryRespository = $categoryRespository;
        $this->imageManager = $imageManager;
    }
    public function getCategories()
    {
        return $this->categoryRespository->getAll();
    }

    public function getCategoriesForDatatable()
    {
        $categories = $this->categoryRespository->getAll();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('name', function ($category) {
                return $category->getTranslation('name', app()->getLocale());
            })
            ->addColumn('status', function ($category) {
                return $category->getStatusTranslated();
            })
            ->addColumn('products_count', function ($category) {
                return $category->products()->count() == 0 ? __('dashboard.not_found') : $category->products()->count();
            })
            ->addColumn('icon', function ($category) {
                return view('dashboard.categories.datatables.icon',compact('category'));
            })
            ->addColumn('action', function ($category) {
                return view('dashboard.categories.datatables.actions', compact('category'));
            })

            ->make(true);
    }

    public function store($data)
    {
        if (array_key_exists('icon', $data)  && $data['icon'] != null) {
            $file_name = $this->imageManager->uploadSingleImage('/', $data['icon'], 'categories');
            $data['icon'] = $file_name;
        }
        return $this->categoryRespository->store($data);
    }
    public function findById($id)
    {
        return $this->categoryRespository->findById($id);
    }

    public function update($data)
    {
        $category = $this->categoryRespository->findById($data['id']);
        if (!$category) {
            return false;
        }

        if (array_key_exists('icon', $data) && $data['icon'] != null) {
            $this->imageManager->deleteImageFromLocal($category->icon);

            $file_name = $this->imageManager->uploadSingleImage('/', $data['icon'], 'categories');
            $data['icon'] = $file_name;
        }

        return $this->categoryRespository->update($category, $data);
    }
    public function delete($id)
    {
        $category = $this->categoryRespository->findById($id);

        if ($category->icon != null) {
            $this->imageManager->deleteImageFromLocal($category->icon);
        }

        return $this->categoryRespository->delete($category);
    }

    public function getParentCategories()
    {
        return $this->categoryRespository->getParentCategories();
    }



    public function getCategoriesExceptChildren($id)
    {
        return $this->categoryRespository->getCategoriesExceptChildren($id);
    }
}