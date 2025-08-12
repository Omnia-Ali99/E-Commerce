<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Database\Seeders\SliderSeeder;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\SliderService;

class SliderController extends Controller
{
    protected $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index()
    {
        return view('dashboard.sliders.index');
    }

    public function getAll()
    {
        return $this->sliderService->getSlidersForDatatables();
    }

    public function store(SliderRequest $request)
    {
        $data   = $request->only(['note', 'file_name']);
        $slider = $this->sliderService->createSlider($data);

        if(!$slider){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();

    }

    public function destroy(string $id)
    {
        if(!$this->sliderService->deleteSlider($id)){
            return response()->json([
                'status'=>'error',
                'message'=>__('dashboard.error_msg'),
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>__('dashboard.success_msg'),
        ],200);

    }
}