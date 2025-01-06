<?php

namespace App\Services\Auth;

use App\Notifications\SendOtpNotify;
use App\Repositories\Auth\PasswordRepository;

class PasswordService
{
    protected $passwordRepository;
    public function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }
    public function sendOtp($email)
    {
        $admin = $this->passwordRepository->getAdminByEmail($email);
        if (!$admin) {
            return false;
        }
        $admin->notify(new SendOtpNotify());
        return $admin;
    }

    public function verifyOtp($data)
    {
        $otp = $this->passwordRepository->verifyOtp($data);
        return $otp->status;
    }
    public function resetPassword($email, $password)
    {
        return $this->passwordRepository->resetPassword($email, $password);
    }
}
