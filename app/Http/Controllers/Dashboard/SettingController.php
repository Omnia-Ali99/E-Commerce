<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\SettingService;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       protected $settingService;
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        return view('dashboard.settings.index');
    }
    public function update(SettingRequest $request , $id)
    {
        $data = $request->except(['_token' , '_method']);
        $setting = $this->settingService->updateSetting($data , $id);
        if(!$setting){
            Session::flash('error' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->back();

    }
}
