<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Google2FA;
use App\Services\AuthService;
use App\Services\TwoFactorService;

class TwoFactorController extends Controller
{

    protected $authService;
    protected $twoFactorService;

    public function __construct(AuthService $authService,TwoFactorService $twoFactorService)
    {
        $this->authService = $authService;
        $this->twoFactorService = $twoFactorService;
    }

    public function enableTwoFactor()
    {
        $user = $this->authService->getAuthenticatedUser();
        $google2fa = app('pragmarx.google2fa');
        $user->google2fa_secret = $google2fa->generateSecretKey();
        $user->google2fa_enabled = true;
        $user->save();
        return response()->json([
            'message' => 'TwoFactor Enable Successfully.'
        ], 200);
    }

    public function disableTwoFactor()
    {
        $user = $this->authService->getAuthenticatedUser();
        $user->google2fa_secret = null;
        $user->google2fa_enabled = false;
        $user->save();

        return response()->json([
            'message' => 'TwoFactor Disable Successfully.'
        ], 200);
    }

}
