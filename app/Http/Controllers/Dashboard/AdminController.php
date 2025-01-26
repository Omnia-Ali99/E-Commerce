<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Services\Dashboard\RoleService;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\AdminService;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $adminService , $roleService;
    public function __construct(AdminService $adminService, RoleService $roleService)
    {
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }
    public function index()
    {
        $admins = $this->adminService->getAdmins();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getRoles();
        return view('dashboard.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', 'role_id', 'status']);
        $admin = $this->adminService->storeAdmin($data);
        if (!$admin) {
            Session::flash('error', __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success', __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = $this->roleService->getRoles();
        $admin = $this->adminService->getAdmin($id);
        if (!$admin) {
            Session::flash('error', 'admin not found');
            return redirect()->back();
        }
        return view('dashboard.admins.edit', ['admin' => $admin, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $data = $request->only(['name', 'email', 'password', 'role_id',  'status']);

        if (!$this->adminService->updateAdmin($data, $id)) {
            Session::flash('erorr', __('dashboard.error_msg'));
            return redirect()->back();
        }

        Session::flash('success', __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }
    public function changeStatus($id)
    {
        if(!$this->adminService->changeStatus($id)){
            Session::flash('erorr' , __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = $this->adminService->destroy($id);
        if (!$admin) {
            Session::flash('erorr', __('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success', __('dashboard.success_msg'));
        return redirect()->route('dashboard.admins.index');
    }
}
