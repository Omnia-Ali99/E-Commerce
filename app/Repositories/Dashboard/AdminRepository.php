<?php

namespace App\Repositories\Dashboard;

use App\Models\Admin;

class AdminRepository
{
    /**
     * Create a new class instance.
     */
    public function getAdmins()
    {
        $admins = Admin::select('id', 'name', 'email', 'created_at', 'role_id','status')->paginate(6);
        return $admins;
    }
    public function getAdmin($id)
    {
        $admin = Admin::find($id);
        return $admin;
    }
    public function storeAdmin($data)
    {
        $admin = Admin::create($data);
        return $admin;
    }
    public function updateAdmin($data, $admin)
    {
        $admin = $admin->update($data);
        return $admin;
    }
    public function destroy($admin)
    {
        return $admin->delete();
    }
    public function changeStatus($admin, $status)
    {
        $admin = $admin->update([
            'status' =>  $status
        ]);
        return $admin;
    }
}
