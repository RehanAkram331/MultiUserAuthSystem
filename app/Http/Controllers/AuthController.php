<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $authService;
    protected $twoFactorService;

    public function __construct(AuthService $authService,TwoFactorService $twoFactorService)
    {
        $this->authService = $authService;
        $this->twoFactorService = $twoFactorService;
    }

    public function showLoginForm()
    {
        $user = $this->authService->getAuthenticatedUser();
        
        if ($user) {
            return redirect($this->authService->redirectTo($user));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user=$this->authService->attemptLogin($request);
        if($user){
            if ($user->google2fa_secret) {
                return redirect()->route('2fa.verify');
            }
            return redirect($this->authService->redirectTo($user));
        }
        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }
    
    public function show2FAVerifyForm()
    {
        $user = $this->authService->getAuthenticatedUser();
        $QR_Image = $this->twoFactorService->getQRCode($user);

        return view('auth.2fa_verify', ['QR_Image' => $QR_Image]);
    }

    public function verify2FA(Request $request)
    {
        $user = $this->authService->getAuthenticatedUser();
        $user=$this->twoFactorService->verify2FA($request,$user);
        if($user){
            return redirect($this->authService->redirectTo($user));
        }
        return redirect()->back()->withErrors(['verify-code' => 'Invalid verification code, please try again.']);
    }

    public function logout(Request $request)
    {
        session()->flush();
        $user = $this->authService->getAuthenticatedUser();
        
        if ($user) {
            $user->google2fa_enabled = false;
            $user->save();
        }

        foreach (['web', 'student', 'teacher'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function home(){
        $user = $this->authService->getAuthenticatedUser();

        if ($user) {
            return redirect($this->authService->redirectTo($user));
        }

        return redirect()->route('login');
    }
}