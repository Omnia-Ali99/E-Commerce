<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\RoleRepository;

class RoleService
{
    protected $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function createRole($request)
    {
        $role = $this->roleRepository->createRole($request);
        return $role;
    }
    public function getRoles()
    {
        return $this->roleRepository->getRoles();
    }
    public function getRole($id)
    {
        return $this->roleRepository->getRole($id);
    }
    public function updateRole($request, $id)
    {
        $role = $this->roleRepository->getRole($id);
        if (!$role) {
            return false;
        }
        return $this->roleRepository->updateRole($request, role: $role);
    }
    public function destroy($id)
    {
        $role = $this->roleRepository->getRole($id);

        if($role->admins->count()>0 || !$role){
            return false;
        }
      
        return $this->roleRepository->destroy($role);

    }
}
