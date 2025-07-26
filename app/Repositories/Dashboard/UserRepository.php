<?php

namespace App\Repositories\Dashboard;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::get();
    }
    public function getUser($id)
    {
        return User::find($id);
    }

    public function storeUser($data)
    {
       return User::create($data);
    }

    public function updateUser($data, $user)
    {
        return $user->update($data);
    }

    public function destroy($user)
    {
        return $user->delete();
    }

    public function changeStatus($user , $status)
    {
        return $user->update([
            'is_active'=>$status,
        ]);
    }

}