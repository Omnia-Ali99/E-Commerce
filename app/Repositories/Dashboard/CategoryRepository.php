<?php

namespace App\Repositories\Dashboard;

use App\Models\Category;

class CategoryRepository
{

    public function getAll()
    {
        $categories = Category::latest()->get();
        return $categories;
    }
    public function findById($id)
    {
        $category = Category::find($id);
        return $category;
    }

    public function store($data)
    {
        $category = Category::create($data);
        return $category;
    }

    public function update($category, $data)
    {
        $category = $category->update($data);
        return $category;
    }

    public function delete($category)
    {
        return $category->delete();
    }

    public function getParentCategories()
    {
        $categories = Category::whereNull('parent')->get();
        return  $categories;
    }
    public function getCategoriesExceptChildren($id)
    {
        $categories = Category::where('id', '!=', $id)
        ->whereNull('parent')
        ->get();
        return  $categories;
    }

}
