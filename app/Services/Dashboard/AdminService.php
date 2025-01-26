<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\AdminRepository;

class AdminService
{
    /**
     * Create a new class instance.
     */
    public $adminRepository;
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    public function getAdmins()
    {
        $admins = $this->adminRepository->getAdmins();
        return $admins;
    }
    public function getAdmin($id)
    {
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            return false;
        }
        return $admin;
    }
    public function storeAdmin($data)
    {
        $admin = $this->adminRepository->storeAdmin($data);
        if (!$admin) {
            return false;
        }
        return $admin;
    }
    public function updateAdmin($data, $id)
    {
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            abort(404);
        }
        if($data['password'] == null){
            unset($data['password']);
        }
        $admin = $this->adminRepository->updateAdmin($data, $admin);
        if (!$admin) {
            return false;
        }
        return $admin;
    }
    public function destroy($id)
    {
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            abort(404);
        }
        $admin = $this->adminRepository->destroy($admin);
        return $admin;
    }
    public function changeStatus($id) {
        $admin = $this->adminRepository->getAdmin($id);
        if (!$admin) {
            abort(404);
        }
        $admin->status == 'Active'? $status = 0 : $status = 1;
        $status = $this->adminRepository->changeStatus($admin,$status);
        return $status;
    }
}
