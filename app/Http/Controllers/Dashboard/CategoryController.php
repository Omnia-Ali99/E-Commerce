<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Dashboard\CategoryService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $edit_categories = $this->categoryService->getCategoriesExceptChildren(1);
        return view('dashboard.categories.index' , compact('edit_categories'));
    }
    public function getAll()
    {
        return  $this->categoryService->getCategoriesForDatatable();
    }

    public function create()
    {
        $categories = $this->categoryService->getParentCategories();
        return view('dashboard.categories.create' , compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->only(['name' , 'parent' , 'status']);
        if(!$this->categoryService->store($data)){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();
    }


    public function edit(string $id)
    {
        $category = $this->categoryService->findById($id);
        $categories = $this->categoryService->getCategoriesExceptChildren($id);
        return view('dashboard.categories.edit' , compact('categories' , 'category'));
    }


    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->only(['name' , 'parent' , 'status' , 'id']);
        if(!$this->categoryService->update($data)){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        if(!$this->categoryService->delete($id)){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();
    }
}
