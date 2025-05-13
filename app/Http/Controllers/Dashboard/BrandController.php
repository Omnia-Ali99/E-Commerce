<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\BrandService;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $brandService;
    public function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }
    public function index()
    {
        return view('dashboard.brands.index');
        }
    public function getAll(){
        return $this->brandService->getBrandsForDatatables();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(BrandRequest $request)
    {
        $data = $request->only(['name', 'status', 'logo']);
        $brand = $this->brandService->createBrand($data);

        if(!$brand){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = $this->brandService->getBrand($id);
        return view('dashboard.brands.edit' , compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
      public function update(BrandRequest $request, string $id)
    {
        $data = $request->only(['name', 'status', 'logo']);

        $brand = $this->brandService->updateBrand($id , $data);
        if(!$brand){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$this->brandService->deleteBrand($id)){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();
    }
}
