<?php

namespace App\Services;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQRCode;

class TwoFactorService
{
    protected $google2fa;
    protected $google2faQRCode;

    public function __construct(Google2FA $google2fa, Google2FAQRCode $google2faQRCode)
    {
        $this->google2fa = $google2fa;
        $this->google2faQRCode = $google2faQRCode;
    }

    public function verify2FA(Request $request,$user)
    {
        
        $secret = trim($user->google2fa_secret);
        $code = trim($request->input('verify-code'));

        //$valid = $this->google2fa->verifyKey($secret, $code);

        if ($secret==$code) {
            $user->google2fa_enabled = true;
            $user->save();
            return $user;
        } 
        return false;
    }

    public function getQRCode($user)
    {
        return $this->google2faQRCode->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
    }
}