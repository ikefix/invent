<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login based on their role.
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return '/admin-dashboard';
        } elseif ($user->role === 'manager') {
            return '/manager-dashboard';
        } elseif ($user->role === 'cashier') {
            // Default dashboard (cashier)
            return '/cashier-dashboard';
        } elseif ($user->role === 'employee') {
            return '/';
        }
        return '/';
    }

    /**
     * Override credentials method to include role validation during login.
     */
    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role, // Ensure role matches during login
        ];
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
