<?php

namespace App\Repositories\Auth;

use App\Models\Admin;
use Ichtrojan\Otp\Otp;

class PasswordRepository
{
    protected $otp;
    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }
    public function getAdminByEmail($email)
    {
        $admin = Admin::where('email', $email)->first();
        return $admin;
    }
    public function verifyOtp($data)
    {
        $otp = $this->otp->validate($data['email'], $data['code']);
        return $otp;
    }
    public function resetPassword($email, $password)
    {
        $admin = self::getAdminByEmail($email);
        $admin->update([
            'password' => bcrypt($password),
        ]);
        return $admin;
    }
}
