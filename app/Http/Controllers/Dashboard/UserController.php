<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Dashboard\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        return view('dashboard.users.index');
    }
    public function getAll()
    {
        return $this->userService->getUsersForDatatable();
    }

    public function create()
    {

    }

    public function store(UserRequest $request)
    {
        $data = $request->only([
            'name','email','password','country_id','governorate_id','city_id','is_active'
        ]);

        $createUser = $this->userService->storeUser($data);

        if(!$createUser){
            return response()->json([
                'status' => 'error',
                 'message' => 'Something went wrong'
                ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
        ],201);
    }


    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {
        if (!$this->userService->deleteUser($id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg')
        ], 200);
    }
    public function changeStatus(Request $request)
    {
        if ($this->userService->changeStatus($request->id)) {
            return response()->json([
                'status' => 'success',
                'message' => __('dashboard.success_msg'),
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Status not changed'
        ]);
    }
}