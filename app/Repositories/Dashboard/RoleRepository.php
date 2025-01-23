<?php

namespace App\Repositories\Dashboard;

use App\Models\Role;

class RoleRepository
{
    public function getRole($id){
        $role = Role::find($id);
        return $role;
    }
  
    
    public function createRole($request)
    {
       $role = Role::create([
            'role'=>[
                'ar'=>$request->role['ar'],
                'en'=>$request->role['en'],
            ],
            'permession'=>json_encode($request->permessions),
       ]);

       return $role;

    }
    public function getRoles(){
        $roles = Role::select('id','role','permession')->paginate(6);
        return $roles;
    }
    

    public function updateRole($request , $role)
    {
       $role = $role->update([
            'role'=>$request->role,
            'permession'=>json_encode($request->permessions),
        ]);
        return $role;

    }
    public function destroy($role)
    {
        return $role->delete();
    }

}
